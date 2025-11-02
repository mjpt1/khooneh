<?php

// Define a constant for the application root path.
define('APP_PATH', dirname(__DIR__));

// Require the custom autoloader.
require_once APP_PATH . '/app/autoload.php';

// Load the configuration.
// In a real deployment, you would copy config.php.example to config.php
$configPath = APP_PATH . '/config.php';
if (!file_exists($configPath)) {
    die('Configuration file not found. Please copy config.php.example to config.php and fill in your details.');
}
$config = require_once $configPath;

// Set the default timezone.
date_default_timezone_set($config['app']['default_timezone'] ?? 'UTC');

// Establish a database connection.
try {
    App\Core\Database::connect($config['database']);
} catch (\Exception $e) {
    // In debug mode, show the error. In production, show a generic error page.
    if ($config['app']['debug']) {
        die('Database Connection Error: ' . $e->getMessage());
    } else {
        die('An unexpected error occurred. Please try again later.');
    }
}

// Start the session.
App\Helpers\Auth::start();
