<?php

/**
 * Custom Autoloader
 *
 * This function is registered with spl_autoload_register to automatically
 * load class files based on their namespace. This mimics Composer's autoloading
 * functionality and is essential for a clean project structure.
 *
 * The autoloader assumes the base namespace 'App' maps to the 'app' directory.
 * For example, a class \App\Core\Router will be looked for in 'app/Core/Router.php'.
 */
spl_autoload_register(function ($class) {
    // Define the base namespace and the base directory for the classes.
    $base_namespace = 'App\\';
    $base_directory = dirname(__DIR__) . '/app/'; // Assumes autoload.php is in 'app'

    // Check if the class uses the base namespace.
    $len = strlen($base_namespace);
    if (strncmp($base_namespace, $class, $len) !== 0) {
        // If not, pass to the next registered autoloader.
        return;
    }

    // Get the relative class name (e.g., Core\Router from App\Core\Router).
    $relative_class = substr($class, $len);

    // Create the full file path by replacing namespace separators with directory separators.
    $file = $base_directory . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it once.
    if (file_exists($file)) {
        require_once $file;
    }
});
