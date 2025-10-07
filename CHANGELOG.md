# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial release of LaraLogs package
- Beautiful web interface for viewing Laravel logs
- Advanced search and filtering capabilities
- Log statistics dashboard
- Download and clear log functionality
- Production environment security controls
- Email-based access restrictions
- Responsive design for all devices
- No external dependencies (pure CSS/JS)
- Configurable log files support
- Custom route prefix support

### Features
- 🎨 Modern, responsive interface
- 🔍 Full-text search across log messages and context
- 📊 Real-time log statistics (entries, file size, last modified)
- 🏷️ Log level filtering (Emergency, Alert, Critical, Error, Warning, Notice, Info, Debug)
- 📥 Download log files for offline analysis
- 🗑️ Clear log files with confirmation dialog
- 🔒 Production security with email-based access control
- 📱 Mobile-first responsive design
- ⚡ Performance optimized with configurable entry limits
- 🎯 Self-contained (no external CSS/JS dependencies)

### Security
- Disabled in production by default
- Email-based access control for production
- Authentication required for all access
- CSRF protection on all forms
- Configurable log file access

### Technical
- Laravel 9+ compatibility
- PSR-4 autoloading
- Service provider architecture
- Middleware-based security
- Configurable routes and middleware
- Publishable configuration and views

## [1.0.0] - 2024-01-XX

### Added
- Initial release
- Core logging interface
- Security controls
- Documentation
- Installation guide

---

## Installation

```bash
composer require laralogs/laralogs
```

## Configuration

```bash
php artisan vendor:publish --provider="LaraLogs\LaraLogsServiceProvider" --tag="laralogs-config"
```

## Usage

Visit `/laralogs` in your application (or your configured route prefix).

## Security

- Set `LARALOGS_ENABLED_IN_PRODUCTION=true` in `.env` to enable in production
- Add authorized emails to `config/laralogs.php`
- Only authenticated users can access LaraLogs
