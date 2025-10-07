<?php

namespace LaraLogs\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LaraLogsAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $config = config('laralogs');

        // If in production and not enabled, deny access
        if (app()->environment('production') && !$config['enabled_in_production']) {
            abort(403, 'LaraLogs is not enabled in production environment.');
        }

        // If in production and enabled, check authentication and allowed emails
        if (app()->environment('production') && $config['enabled_in_production']) {
            // Check if user is authenticated
            if (!Auth::check()) {
                abort(403, 'Unauthorized access to LaraLogs.');
            }

            $user = Auth::user();
            $allowedEmails = $config['allowed_emails'] ?? [];
            
            if (!in_array($user->email, $allowedEmails)) {
                abort(403, 'Your email is not authorized to access LaraLogs.');
            }
        }

        // In development, allow access without authentication
        return $next($request);
    }
}
