#!/bin/bash
# Test runner script for OXID 6.x module

echo "Checking PHP installation..."
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not installed or not in PATH"
    echo "Please install PHP 7.4 or use Docker"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "Found PHP version: $PHP_VERSION"

echo ""
echo "Checking PHPUnit..."
if [ ! -f "vendor/bin/phpunit" ]; then
    echo "PHPUnit not found. Installing dependencies..."
    if command -v composer &> /dev/null; then
        composer install --dev
    else
        echo "ERROR: Composer is not installed"
        echo "Please install Composer: https://getcomposer.org/"
        exit 1
    fi
fi

echo ""
echo "Running tests..."
vendor/bin/phpunit --verbose

