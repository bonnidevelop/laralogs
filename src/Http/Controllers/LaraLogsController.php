<?php

namespace LaraLogs\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller;

class LaraLogsController extends Controller
{
    /**
     * Display the logs index page.
     */
    public function index(Request $request)
    {
        $config = config('laralogs');
        $logFiles = $config['log_files'];
        $selectedLog = $request->get('log', 'laravel');
        
        // Get the first available log file if selected one doesn't exist
        if (!isset($logFiles[$selectedLog])) {
            $selectedLog = array_key_first($logFiles);
        }

        $logPath = $logFiles[$selectedLog]['path'];
        $logs = [];
        $totalSize = 0;
        $lastModified = null;

        if (File::exists($logPath)) {
            $totalSize = File::size($logPath);
            $lastModified = File::lastModified($logPath);
            
            // Read log file content
            $content = File::get($logPath);
            
            // Parse log entries
            $logs = $this->parseLogFile($content);
            
            // Apply filters
            if ($request->has('level') && $request->level !== 'all') {
                $logs = array_filter($logs, function($log) use ($request) {
                    return strtolower($log['level']) === strtolower($request->level);
                });
            }
            
            if ($request->has('search') && !empty($request->search)) {
                $search = strtolower($request->search);
                $logs = array_filter($logs, function($log) use ($search) {
                    return strpos(strtolower($log['message']), $search) !== false ||
                           strpos(strtolower($log['context']), $search) !== false;
                });
            }
            
            // Limit results for performance
            $maxEntries = $config['max_entries'] ?? 1000;
            $logs = array_slice($logs, 0, $maxEntries);
        }

        return view('laralogs::index', compact('logs', 'totalSize', 'lastModified', 'logFiles', 'selectedLog'));
    }

    /**
     * Clear the log file.
     */
    public function clear(Request $request)
    {
        $config = config('laralogs');
        $logFiles = $config['log_files'];
        $selectedLog = $request->get('log', 'laravel');
        
        if (!isset($logFiles[$selectedLog])) {
            return redirect()->route('laralogs.index')
                ->with('error', 'Log file not found!');
        }

        $logPath = $logFiles[$selectedLog]['path'];
        
        if (File::exists($logPath)) {
            File::put($logPath, '');
            return redirect()->route('laralogs.index', ['log' => $selectedLog])
                ->with('success', 'Log file cleared successfully!');
        }
        
        return redirect()->route('laralogs.index', ['log' => $selectedLog])
            ->with('error', 'Log file not found!');
    }

    /**
     * Download the log file.
     */
    public function download(Request $request)
    {
        $config = config('laralogs');
        $logFiles = $config['log_files'];
        $selectedLog = $request->get('log', 'laravel');
        
        if (!isset($logFiles[$selectedLog])) {
            return redirect()->route('laralogs.index')
                ->with('error', 'Log file not found!');
        }

        $logPath = $logFiles[$selectedLog]['path'];
        
        if (File::exists($logPath)) {
            $fileName = $selectedLog . '-' . date('Y-m-d-H-i-s') . '.log';
            return response()->download($logPath, $fileName);
        }
        
        return redirect()->route('laralogs.index', ['log' => $selectedLog])
            ->with('error', 'Log file not found!');
    }

    /**
     * Delete a single log entry by hash.
     */
    public function delete(Request $request)
    {
        $request->validate([
            'hash' => 'required|string',
            'log' => 'nullable|string'
        ]);

        $config = config('laralogs');
        $logFiles = $config['log_files'];
        $selectedLog = $request->get('log', 'laravel');

        if (!isset($logFiles[$selectedLog])) {
            return redirect()->route('laralogs.index')->with('error', 'Log file not found!');
        }

        $logPath = $logFiles[$selectedLog]['path'];
        $targetHash = $request->input('hash');

        if (!File::exists($logPath)) {
            return redirect()->route('laralogs.index', ['log' => $selectedLog])->with('error', 'Log file not found!');
        }

        $content = File::get($logPath);
        $lines = preg_split("/\r?\n/", $content);

        $blocks = [];
        $current = [];
        foreach ($lines as $line) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] \w+\.\w+: /', $line)) {
                if (!empty($current)) {
                    $blocks[] = $current;
                }
                $current = [$line];
            } else {
                $current[] = $line;
            }
        }
        if (!empty($current)) {
            $blocks[] = $current;
        }

        $keptBlocks = [];
        $deleted = false;
        foreach ($blocks as $block) {
            $raw = rtrim(implode("\n", $block));
            if ($raw === '') {
                continue;
            }
            $timestamp = '';
            $level = '';
            $message = '';
            $context = '';
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.*)$/', $block[0], $m)) {
                $timestamp = $m[1] ?? '';
                $level = strtoupper($m[2] ?? '');
                $message = $m[3] ?? '';
                if (count($block) > 1) {
                    $contextLines = array_slice($block, 1);
                    $contextLines = array_filter($contextLines, function ($l) {
                        return trim($l) !== '';
                    });
                    $context = rtrim(implode("\n", $contextLines));
                }
            }
            $hash = hash('sha256', $timestamp . '|' . $level . '|' . $message . '|' . trim($context));
            if (!$deleted && hash_equals($targetHash, $hash)) {
                $deleted = true;
                continue;
            }
            $keptBlocks[] = $raw;
        }

        File::put($logPath, implode("\n", $keptBlocks) . (empty($keptBlocks) ? '' : "\n"));

        return redirect()->route('laralogs.index', ['log' => $selectedLog])
            ->with($deleted ? 'success' : 'error', $deleted ? 'Log entry deleted.' : 'Log entry not found.');
    }

    /**
     * Parse log file content.
     */
    private function parseLogFile($content)
    {
        $logs = [];
        $lines = explode("\n", $content);
        $currentLog = null;
        
        foreach ($lines as $line) {
            // Match Laravel log format: [timestamp] environment.LEVEL: message
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.+)$/', $line, $matches)) {
                // Save previous log if exists
                if ($currentLog) {
                    $logs[] = $currentLog;
                }
                
                // Start new log entry
                $currentLog = [
                    'timestamp' => $matches[1],
                    'level' => strtoupper($matches[2]),
                    'message' => $matches[3],
                    'context' => ''
                ];
            } elseif ($currentLog && !empty(trim($line))) {
                // Add context lines to current log
                $currentLog['context'] .= $line . "\n";
            }
        }
        
        // Add the last log entry
        if ($currentLog) {
            $logs[] = $currentLog;
        }
        
        // Reverse to show newest first
        return array_reverse($logs);
    }
}
