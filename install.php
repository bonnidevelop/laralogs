<?php

/**
 * LaraLogs Installation Script
 * 
 * This script helps set up LaraLogs in your Laravel application
 * Run: php install.php
 */

echo "🚀 LaraLogs Installation Script\n";
echo "================================\n\n";

// Check if we're in a Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: This doesn't appear to be a Laravel project.\n";
    echo "Please run this script from your Laravel project root.\n";
    exit(1);
}

echo "✅ Laravel project detected\n";

// Check if config file exists
if (file_exists('config/laralogs.php')) {
    echo "⚠️  Warning: config/laralogs.php already exists\n";
    echo "Skipping config file creation...\n\n";
} else {
    echo "📝 Creating config file...\n";
    // The config will be published via artisan command
    echo "Run: php artisan vendor:publish --provider=\"LaraLogs\\LaraLogsServiceProvider\" --tag=\"laralogs-config\"\n\n";
}

// Check if service provider is registered
$appConfigPath = 'config/app.php';
if (file_exists($appConfigPath)) {
    $appConfig = file_get_contents($appConfigPath);
    if (strpos($appConfig, 'LaraLogs\\LaraLogsServiceProvider') !== false) {
        echo "✅ Service provider already registered\n";
    } else {
        echo "📝 Please add the service provider to config/app.php:\n";
        echo "   'providers' => [\n";
        echo "       // ... other providers\n";
        echo "       LaraLogs\\LaraLogsServiceProvider::class,\n";
        echo "   ],\n\n";
    }
}

// Check routes
echo "🔍 Checking routes...\n";
$routeList = shell_exec('php artisan route:list 2>/dev/null | grep laralogs');
if ($routeList) {
    echo "✅ Routes registered successfully\n";
    echo "Available routes:\n";
    echo $routeList . "\n";
} else {
    echo "⚠️  Routes not found. Make sure the service provider is registered.\n\n";
}

// Environment setup
echo "🔧 Environment Setup:\n";
echo "Add these to your .env file:\n\n";
echo "# LaraLogs Configuration\n";
echo "LARALOGS_ENABLED_IN_PRODUCTION=false\n";
echo "LARALOGS_ROUTE_PREFIX=laralogs\n";
echo "LARALOGS_MAX_ENTRIES=1000\n\n";

// Security reminder
echo "🔒 Security Reminder:\n";
echo "- LaraLogs is disabled in production by default\n";
echo "- Add authorized emails to config/laralogs.php for production access\n";
echo "- Only authenticated users can access LaraLogs\n\n";

// Final instructions
echo "🎉 Installation Complete!\n";
echo "========================\n\n";
echo "Next steps:\n";
echo "1. Publish config: php artisan vendor:publish --provider=\"LaraLogs\\LaraLogsServiceProvider\" --tag=\"laralogs-config\"\n";
echo "2. Configure authorized emails in config/laralogs.php\n";
echo "3. Visit: http://your-app.com/laralogs\n";
echo "4. Login with an authorized user account\n\n";

echo "📚 Documentation: https://github.com/laralogs/laralogs\n";
echo "🐛 Issues: https://github.com/laralogs/laralogs/issues\n\n";

echo "Happy logging! 🚀\n";
