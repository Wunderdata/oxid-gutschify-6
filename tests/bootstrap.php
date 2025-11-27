<?php
/**
 * PHPUnit bootstrap file for OXID 6.x module tests
 *
 * @package Gutschify
 * @author Gutschify Team
 */

// Include OXID bootstrap if available
// Adjust path based on your OXID installation
if (file_exists(__DIR__ . '/../../../../bootstrap.php')) {
    require_once __DIR__ . '/../../../../bootstrap.php';
}

// Autoloader for module classes
spl_autoload_register(function ($class) {
    $prefix = '';
    $baseDir = __DIR__ . '/../../src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

