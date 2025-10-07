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
