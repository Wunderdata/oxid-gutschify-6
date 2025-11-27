# Running Tests for OXID 6.x Module

## Prerequisites

To run the tests, you need:
- PHP 7.4 or lower
- PHPUnit 5.7
- Composer (for dependency management)

## Installation

### Option 1: Install PHP and PHPUnit locally

**macOS (Homebrew):**
```bash
brew install php@7.4
brew link php@7.4
composer require --dev phpunit/phpunit:^5.7
```

**Linux:**
```bash
sudo apt-get install php7.4 php7.4-cli php7.4-xml
composer require --dev phpunit/phpunit:^5.7
```

### Option 2: Use Docker

```bash
docker run --rm -v $(pwd):/app -w /app php:7.4-cli \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  php composer-setup.php && \
  php composer.phar require --dev phpunit/phpunit:^5.7 && \
  vendor/bin/phpunit
```

## Running Tests

Once PHP and PHPUnit are installed:

```bash
cd oxid-gutschify-6
vendor/bin/phpunit
```

Or with specific options:

```bash
# Run with verbose output
vendor/bin/phpunit --verbose

# Run specific test file
vendor/bin/phpunit tests/Unit/Service/GutschifyServiceTest.php

# Run specific test method
vendor/bin/phpunit --filter testFetchEmbeddedHomeEmptyBaseUrl
```

## Expected Results

Many tests are marked as `incomplete` because they require:
- Mocking of OXID static classes (oxConfig, oxRegistry)
- cURL mocking or test HTTP server
- Full OXID environment

Tests that should pass:
- `testFetchEmbeddedHomeEmptyBaseUrl` - Input validation
- `testFetchEmbeddedHomeEmptyOrganizationId` - Input validation
- `testConnectionErrorHandling` - Error handling (if network allows)
- `testSanitizeHtml` - HTML sanitization
- `testCacheFilePathGeneration` - Cache path generation (if oxConfig can be mocked)

## Troubleshooting

### PHP not found
Install PHP 7.4 via your system's package manager or use Docker.

### PHPUnit not found
Install via Composer: `composer require --dev phpunit/phpunit:^5.7`

### Class not found errors
Ensure `tests/bootstrap.php` is properly configured and autoloading works.

### OXID class errors
These tests require OXID environment or advanced mocking. See test file comments for details.

