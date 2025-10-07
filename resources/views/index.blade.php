<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraLogs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-outline-primary {
            background-color: transparent;
            color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-outline-danger {
            background-color: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .btn-outline-secondary {
            background-color: transparent;
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-title {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .text-primary { color: #007bff; }
        .text-info { color: #17a2b8; }
        .text-success { color: #28a745; }

        .filters {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            border: 1px solid #e9ecef;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 20px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.search-group {
            position: relative;
        }

        .form-group.actions-group {
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: stretch;
        }

        .form-group.actions-group .btn {
            flex: 1;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            background-color: white;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: #6c757d;
            font-style: italic;
        }

        .search-input {
            position: relative;
        }

        .log-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .log-entry {
            border-left: 4px solid #dee2e6;
            margin-bottom: 15px;
            background: white;
            border-radius: 4px;
            overflow: hidden;
        }

        .log-entry.error {
            border-left-color: #dc3545;
        }

        .log-entry.warning {
            border-left-color: #ffc107;
        }

        .log-entry.info {
            border-left-color: #17a2b8;
        }

        .log-entry.debug {
            border-left-color: #6c757d;
        }

        .log-entry.emergency,
        .log-entry.alert,
        .log-entry.critical {
            border-left-color: #dc3545;
        }

        .log-entry.notice {
            border-left-color: #17a2b8;
        }

        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .log-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .bg-danger { background-color: #dc3545; color: white; }
        .bg-warning { background-color: #ffc107; color: #212529; }
        .bg-info { background-color: #17a2b8; color: white; }
        .bg-secondary { background-color: #6c757d; color: white; }
        .bg-primary { background-color: #007bff; color: white; }

        .text-muted {
            color: #6c757d;
            font-size: 12px;
        }

        .log-message {
            font-family: 'Courier New', monospace;
            word-break: break-all;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .log-context {
            background-color: #f8f9fa;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e9ecef;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border: 1px solid transparent;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
        }

        .hidden {
            display: none !important;
        }

        /* Modal styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .modal-text {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .filter-form {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .form-group.actions-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .header-actions {
                justify-content: center;
            }

            .filters {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .filter-form {
                gap: 12px;
            }
            
            .form-control, .form-select {
                padding: 10px 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h5 class="card-title">LaraLogs</h5>
                    <div class="header-actions">
                        <a href="{{ route('laralogs.download', ['log' => $selectedLog]) }}" class="btn btn-outline-primary btn-sm">
                            📥 Download
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearLogs()">
                            🗑️ Clear Logs
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <!-- Log File Selector -->
                @if(count($logFiles) > 1)
                <div class="filters">
                    <form method="GET" action="{{ route('laralogs.index') }}" class="filter-form">
                        <div class="form-group">
                            <label for="log" class="form-label">📁 Select Log File</label>
                            <select class="form-select" id="log" name="log" onchange="this.form.submit()">
                                @foreach($logFiles as $key => $logFile)
                                <option value="{{ $key }}" {{ $selectedLog == $key ? 'selected' : '' }}>
                                    {{ $logFile['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Log Statistics -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-title">Total Entries</div>
                        <h4 class="stat-value text-primary">{{ count($logs) }}</h4>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">File Size</div>
                        <h4 class="stat-value text-info">
                            @if($totalSize > 0)
                            {{ number_format($totalSize / 1024 / 1024, 2) }} MB
                            @else
                            0 MB
                            @endif
                        </h4>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Last Modified</div>
                        <h4 class="stat-value text-success">
                            @if($lastModified)
                            {{ date('M d, H:i', $lastModified) }}
                            @else
                            Never
                            @endif
                        </h4>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters">
                    <form method="GET" action="{{ route('laralogs.index') }}" class="filter-form">
                        <input type="hidden" name="log" value="{{ $selectedLog }}">
                        <div class="form-group search-group">
                            <label for="search" class="form-label">🔍 Search Logs</label>
                            <div class="search-input">
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Search in messages, context, or timestamps...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="level" class="form-label">📊 Log Level</label>
                            <select class="form-select" id="level" name="level">
                                <option value="all" {{ request('level')=='all' ? 'selected' : '' }}>All Levels</option>
                                <option value="emergency" {{ request('level')=='emergency' ? 'selected' : '' }}>🚨 Emergency</option>
                                <option value="alert" {{ request('level')=='alert' ? 'selected' : '' }}>⚠️ Alert</option>
                                <option value="critical" {{ request('level')=='critical' ? 'selected' : '' }}>💥 Critical</option>
                                <option value="error" {{ request('level')=='error' ? 'selected' : '' }}>❌ Error</option>
                                <option value="warning" {{ request('level')=='warning' ? 'selected' : '' }}>⚠️ Warning</option>
                                <option value="notice" {{ request('level')=='notice' ? 'selected' : '' }}>📢 Notice</option>
                                <option value="info" {{ request('level')=='info' ? 'selected' : '' }}>ℹ️ Info</option>
                                <option value="debug" {{ request('level')=='debug' ? 'selected' : '' }}>🐛 Debug</option>
                            </select>
                        </div>
                        <div class="form-group actions-group">
                            <button type="submit" class="btn btn-primary">🔍 Filter Logs</button>
                            <a href="{{ route('laralogs.index', ['log' => $selectedLog]) }}" class="btn btn-outline-secondary">🔄 Clear</a>
                        </div>
                    </form>
                </div>

                <!-- Log Entries -->
                @if(count($logs) > 0)
                <div class="log-container">
                    @foreach($logs as $log)
                    <div class="log-entry {{ strtolower($log['level']) }}">
                        <div class="card-body">
                            <div class="log-header">
                                <div class="log-meta">
                                    <span class="badge 
                                                @switch(strtolower($log['level']))
                                                    @case('emergency')
                                                    @case('alert')
                                                    @case('critical')
                                                    @case('error')
                                                        bg-danger
                                                        @break
                                                    @case('warning')
                                                        bg-warning
                                                        @break
                                                    @case('notice')
                                                    @case('info')
                                                        bg-info
                                                        @break
                                                    @case('debug')
                                                        bg-secondary
                                                        @break
                                                    @default
                                                        bg-primary
                                                @endswitch
                                            ">{{ $log['level'] }}</span>
                                    <small class="text-muted">{{ $log['timestamp'] }}</small>
                                </div>
                            </div>

                            <div class="log-message">
                                {{ $log['message'] }}
                            </div>

                            @if(!empty(trim($log['context'])))
                            <div class="log-context">
                                <small>{{ trim($log['context']) }}</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if(count($logs) >= 1000)
                <div class="alert alert-info">
                    ℹ️ Showing first 1000 entries. Use filters to narrow down results or download the full log file.
                </div>
                @endif
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📄</div>
                    <h5>No Log Entries Found</h5>
                    <p>
                        @if(request('search') || request('level') != 'all')
                        No entries match your current filters.
                        @else
                        The log file is empty or doesn't exist yet.
                        @endif
                    </p>
                </div>
                @endif

            </div>
        </div>
    </div>

    <form action="{{ route('laralogs.clear') }}" method="POST" id="clearform">
        @csrf
        @method('DELETE')
        <input type="hidden" name="log" value="{{ $selectedLog }}">
    </form>

    <!-- Success/Error Messages -->
    @if (session('success'))
    <div id="successMessage" class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1001; background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div id="errorMessage" class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1001; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        ❌ {{ session('error') }}
    </div>
    @endif

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-title">⚠️ Are you sure?</div>
            <div class="modal-text">This will permanently delete all log entries!</div>
            <div class="modal-actions">
                <button type="button" class="btn btn-success" onclick="confirmClear()">Yes, clear logs!</button>
                <button type="button" class="btn btn-outline-danger" onclick="cancelClear()">No, cancel!</button>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            const successMsg = document.getElementById('successMessage');
            const errorMsg = document.getElementById('errorMessage');
            
            if (successMsg) {
                setTimeout(() => {
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.remove(), 300);
                }, 3000);
            }
            
            if (errorMsg) {
                setTimeout(() => {
                    errorMsg.style.opacity = '0';
                    setTimeout(() => errorMsg.remove(), 300);
                }, 5000);
            }
        });

        function clearLogs() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('show');
        }

        function confirmClear() {
            document.getElementById('clearform').submit();
        }

        function cancelClear() {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('show');
        }

        // Close modal when clicking outside
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                cancelClear();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cancelClear();
            }
        });
    </script>
</body>

</html>
