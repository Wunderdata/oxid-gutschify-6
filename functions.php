<?php
/**
 * Module bootstrap file for Gutschify module
 * This file is automatically loaded by OXID to register module classes
 */

// Load all module classes immediately
require_once __DIR__ . '/src/Exception/GutschifyException.php';
require_once __DIR__ . '/src/Service/GutschifyService.php';
require_once __DIR__ . '/src/Controller/GutschifyWidgetController.php';

