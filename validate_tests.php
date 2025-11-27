#!/usr/bin/env php
<?php
/**
 * Simple test validation script
 * Validates test file syntax and structure without requiring PHPUnit
 */

echo "Gutschify OXID 6.x Module - Test Validation\n";
echo "==========================================\n\n";

// Check PHP version
$phpVersion = PHP_VERSION;
echo "PHP Version: $phpVersion\n";

if (version_compare($phpVersion, '7.0.0', '<')) {
    echo "WARNING: PHP 7.0+ required for OXID 6.x\n";
} elseif (version_compare($phpVersion, '8.0.0', '>=')) {
    echo "WARNING: PHP 8.0+ may not be compatible with OXID 6.x (requires PHP < 8.0)\n";
} else {
    echo "✓ PHP version is compatible\n";
}

echo "\n";

// Check test file syntax
$testFile = __DIR__ . '/tests/Unit/Service/GutschifyServiceTest.php';
if (file_exists($testFile)) {
    echo "Checking test file syntax...\n";
    $output = [];
    $returnVar = 0;
    exec("php -l $testFile 2>&1", $output, $returnVar);
    
    if ($returnVar === 0) {
        echo "✓ Test file syntax is valid\n";
    } else {
        echo "✗ Test file has syntax errors:\n";
        echo implode("\n", $output) . "\n";
    }
} else {
    echo "✗ Test file not found: $testFile\n";
}

echo "\n";

// Check source files
echo "Checking source files...\n";
$sourceFiles = [
    'src/Exception/GutschifyException.php',
    'src/Service/GutschifyService.php',
    'src/Controller/GutschifyWidgetController.php',
];

$allValid = true;
foreach ($sourceFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        $output = [];
        $returnVar = 0;
        exec("php -l $fullPath 2>&1", $output, $returnVar);
        
        if ($returnVar === 0) {
            echo "✓ $file\n";
        } else {
            echo "✗ $file has syntax errors:\n";
            echo implode("\n", $output) . "\n";
            $allValid = false;
        }
    } else {
        echo "✗ $file not found\n";
        $allValid = false;
    }
}

echo "\n";

// Check for PHPUnit
echo "Checking for PHPUnit...\n";
if (file_exists(__DIR__ . '/vendor/bin/phpunit')) {
    echo "✓ PHPUnit found in vendor/bin/phpunit\n";
    
    // Try to get version
    $output = [];
    exec(__DIR__ . '/vendor/bin/phpunit --version 2>&1', $output);
    if (!empty($output)) {
        echo "  " . $output[0] . "\n";
    }
} else {
    echo "✗ PHPUnit not found\n";
    echo "  Install with: composer require --dev phpunit/phpunit:^5.7\n";
}

echo "\n";

// Summary
echo "==========================================\n";
if ($allValid) {
    echo "✓ All source files have valid syntax\n";
    echo "\nTo run tests:\n";
    echo "  composer install --dev\n";
    echo "  vendor/bin/phpunit\n";
} else {
    echo "✗ Some files have issues that need to be fixed\n";
}

