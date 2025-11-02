<?php

// Define a constant for the project root path.
define('PROJECT_ROOT', dirname(__DIR__));

// Start the application.
// This file handles configuration, database connection, and autoloader.
require_once PROJECT_ROOT . '/app/start.php';

use App\Core\Router;

// Load the routes definition.
$router = Router::load(PROJECT_ROOT . '/app/routes.php');

// Get the request URI and method.
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestType = $_SERVER['REQUEST_METHOD'];

// Dispatch the request to the router.
try {
    $router->dispatch($uri, $requestType);
} catch (Exception $e) {
    // Handle exceptions thrown during controller actions.
    // In debug mode, show the error. In production, show a generic error page.
    $config = require PROJECT_ROOT . '/config.php'; // re-read config for debug flag
    if ($config['app']['debug']) {
        die('Application Error: ' . $e->getMessage());
    } else {
        // Redirect to a generic error page or show a simple message.
        http_response_code(500);
        require_once PROJECT_ROOT . '/templates/errors/500.php'; // You'd create this file
    }
}
