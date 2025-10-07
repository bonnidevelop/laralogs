# LaraLogs 📊

A beautiful Laravel package for viewing and managing application logs with a modern web interface. LaraLogs provides a clean, responsive dashboard to view, search, filter, and manage your Laravel application logs.

## ✨ Features

- 🎨 **Beautiful Interface** - Modern, responsive design with no external dependencies
- 🔍 **Advanced Search** - Search through log messages, context, and timestamps
- 📊 **Log Statistics** - View total entries, file size, and last modified time
- 🏷️ **Log Level Filtering** - Filter by emergency, alert, critical, error, warning, notice, info, debug
- 📥 **Download Logs** - Download log files for offline analysis
- 🗑️ **Clear Logs** - Clear log files with confirmation
- 🔒 **Security** - Production environment restrictions with email-based access control
- 📱 **Responsive** - Works perfectly on desktop, tablet, and mobile devices
- ⚡ **Fast** - Optimized for performance with configurable entry limits

## 🚀 Installation

### Via Composer

```bash
composer require bonnidevelop/laralogs
```

### Manual Installation

1. Clone or download this repository
2. Copy the `packages/laralogs` directory to your Laravel project
3. Add the service provider to your `config/app.php`:

```php
'providers' => [
    // ... other providers
    LaraLogs\LaraLogsServiceProvider::class,
],
```

## 📋 Configuration

### Publish Configuration

```bash
php artisan vendor:publish --provider="LaraLogs\LaraLogsServiceProvider" --tag="laralogs-config"
```

### Environment Variables

Add these to your `.env` file:

```env
# Enable LaraLogs in production (default: false)
LARALOGS_ENABLED_IN_PRODUCTION=false

# Custom route prefix (default: laralogs)
LARALOGS_ROUTE_PREFIX=laralogs

# Maximum log entries to display (default: 1000)
LARALOGS_MAX_ENTRIES=1000
```

### Configuration File

The published config file (`config/laralogs.php`) contains:

```php
return [
    // Enable in production
    'enabled_in_production' => env('LARALOGS_ENABLED_IN_PRODUCTION', false),
    
    // Allowed emails for production access
    'allowed_emails' => [
        'admin@example.com',
        'developer@example.com',
    ],
    
    // Route configuration
    'route_prefix' => env('LARALOGS_ROUTE_PREFIX', 'laralogs'),
    'middleware' => ['web', 'laralogs.auth'],
    
    // Log files to display
    'log_files' => [
        'laravel' => [
            'path' => storage_path('logs/laravel.log'),
            'name' => 'Laravel Logs',
        ],
    ],
    
    // Display settings
    'max_entries' => env('LARALOGS_MAX_ENTRIES', 1000),
];
```

## 🔧 Usage

### Accessing LaraLogs

Once installed, you can access LaraLogs at:

```
http://your-app.com/laralogs
```

### Security Features

#### Development Environment
- Any authenticated user can access LaraLogs
- No additional restrictions

#### Production Environment
- LaraLogs is disabled by default
- To enable: Set `LARALOGS_ENABLED_IN_PRODUCTION=true` in `.env`
- Only users with emails listed in `allowed_emails` config can access
- Add authorized emails to `config/laralogs.php`:

```php
'allowed_emails' => [
    'admin@yourcompany.com',
    'developer@yourcompany.com',
    'support@yourcompany.com',
],
```

### Customizing Log Files

Add more log files to monitor in `config/laralogs.php`:

```php
'log_files' => [
    'laravel' => [
        'path' => storage_path('logs/laravel.log'),
        'name' => 'Laravel Logs',
    ],
    'custom' => [
        'path' => storage_path('logs/custom.log'),
        'name' => 'Custom Application Logs',
    ],
    'api' => [
        'path' => storage_path('logs/api.log'),
        'name' => 'API Logs',
    ],
],
```

### Customizing Routes

Change the route prefix in your `.env`:

```env
LARALOGS_ROUTE_PREFIX=admin/logs
```

This will make LaraLogs accessible at `/admin/logs`.

## 🎨 Customization

### Publishing Views

To customize the interface:

```bash
php artisan vendor:publish --provider="LaraLogs\LaraLogsServiceProvider" --tag="laralogs-views"
```

This will publish the views to `resources/views/vendor/laralogs/`.

### Custom Styling

The package uses inline CSS for a self-contained experience. To customize:

1. Publish the views
2. Modify the CSS in the published view files
3. Or add your own CSS files and remove the inline styles

## 🔒 Security Considerations

- **Production Access**: LaraLogs is disabled in production by default
- **Email Restrictions**: Only specified emails can access in production
- **Authentication Required**: Users must be logged in to access LaraLogs
- **Log File Access**: Only configured log files are accessible
- **CSRF Protection**: All forms include CSRF tokens

## 📱 Features Overview

### Dashboard
- Real-time log statistics
- File size and modification tracking
- Entry count display

### Search & Filter
- Full-text search across messages and context
- Log level filtering (Emergency, Alert, Critical, Error, Warning, Notice, Info, Debug)
- Timestamp-based filtering

### Log Management
- Download log files
- Clear log files with confirmation
- Pagination for large log files

### Responsive Design
- Mobile-first approach
- Touch-friendly interface
- Adaptive layouts for all screen sizes

## 🛠️ Development

### Running Tests

```bash
composer test
```

### Building for Production

```bash
composer install --no-dev --optimize-autoloader
```

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/bonnidevelop/laralogs/issues)
- **Documentation**: [GitHub Repository](https://github.com/bonnidevelop/laralogs)


## 🙏 Acknowledgments

- Laravel Framework
- All contributors and users

---

Made with ❤️ for the Laravel community
