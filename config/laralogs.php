<?php

return [
    /*
    |--------------------------------------------------------------------------
    | LaraLogs Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the LaraLogs package.
    | You can customize these settings according to your needs.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Environment Settings
    |--------------------------------------------------------------------------
    |
    | Set to true to enable LaraLogs in production environment.
    | When false, LaraLogs will only work in local/development environments.
    |
    */
    'enabled_in_production' => env('LARALOGS_ENABLED_IN_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Allowed Emails (Production Only)
    |--------------------------------------------------------------------------
    |
    | List of email addresses that are allowed to access LaraLogs in production.
    | This setting is only used when 'enabled_in_production' is true.
    | In development, any authenticated user can access LaraLogs.
    |
    */
    'allowed_emails' => [
        'admin@example.com',
        'developer@example.com',
        // Add more email addresses as needed
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Customize the route prefix and middleware for LaraLogs.
    |
    */
    'route_prefix' => env('LARALOGS_ROUTE_PREFIX', 'laralogs'),
    'middleware' => ['web', 'laralogs.auth'],

    /*
    |--------------------------------------------------------------------------
    | Log File Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which log files to display and their display names.
    |
    */
    'log_files' => [
        'laravel' => [
            'path' => storage_path('logs/laravel.log'),
            'name' => 'Laravel Logs',
        ],
        // Add more log files as needed
        // 'custom' => [
        //     'path' => storage_path('logs/custom.log'),
        //     'name' => 'Custom Logs',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Settings
    |--------------------------------------------------------------------------
    |
    | Configure how logs are displayed and paginated.
    |
    */
    'max_entries' => env('LARALOGS_MAX_ENTRIES', 1000),
    'entries_per_page' => env('LARALOGS_ENTRIES_PER_PAGE', 50),
];
