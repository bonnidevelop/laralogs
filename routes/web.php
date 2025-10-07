<?php

use Illuminate\Support\Facades\Route;
use LaraLogs\Http\Controllers\LaraLogsController;

$config = config('laralogs');
$prefix = $config['route_prefix'] ?? 'laralogs';
$middleware = $config['middleware'] ?? ['web', 'laralogs.auth'];

Route::prefix($prefix)->middleware($middleware)->group(function () {
    Route::get('/', [LaraLogsController::class, 'index'])->name('laralogs.index');
    Route::delete('/clear', [LaraLogsController::class, 'clear'])->name('laralogs.clear');
    Route::get('/download', [LaraLogsController::class, 'download'])->name('laralogs.download');
});
