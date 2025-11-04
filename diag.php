<?php
echo "<pre>";
echo "<h2>BuildingChargeManager Diagnostic Script</h2>";

echo "<h3>Server Information:</h3>";
echo "<strong>PHP Version:</strong> " . phpversion() . "\n";
echo "<strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . "\n";

echo "\n<h3>File Paths & Execution Context:</h3>";
echo "<strong>Current Working Directory (getcwd):</strong> " . getcwd() . "\n";
echo "<strong>\$_SERVER['DOCUMENT_ROOT']:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "\n";
echo "<strong>\$_SERVER['SCRIPT_FILENAME'] (this file):</strong> " . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . "\n";
echo "<strong>\$_SERVER['REQUEST_URI']:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "<strong>\$_SERVER['PHP_SELF']:</strong> " . ($_SERVER['PHP_SELF'] ?? 'N/A') . "\n";

echo "\n<h3>Apache mod_rewrite Check:</h3>";
if (function_exists('apache_get_modules')) {
    if (in_array('mod_rewrite', apache_get_modules())) {
        echo "<strong>Status:</strong> mod_rewrite APPEARS TO BE 'ENABLED'.\n";
    } else {
        echo "<strong>Status:</strong> mod_rewrite APPEARS TO BE 'DISABLED'.\n";
    }
} else {
    echo "<strong>Status:</strong> Could not determine if mod_rewrite is enabled (apache_get_modules function not available). This is common on some servers, but might indicate a non-Apache server.\n";
}

echo "\n<h3>File Existence Checks:</h3>";
$root_htaccess = __DIR__ . '/.htaccess';
$public_htaccess = __DIR__ . '/public/.htaccess';
$public_index = __DIR__ . '/public/index.php';

echo "<strong>Root .htaccess (/.htaccess):</strong> " . (file_exists($root_htaccess) ? "Exists" : "MISSING") . "\n";
echo "<strong>Public .htaccess (/public/.htaccess):</strong> " . (file_exists($public_htaccess) ? "Exists" : "MISSING") . "\n";
echo "<strong>Public index.php (/public/index.php):</strong> " . (file_exists($public_index) ? "Exists" : "MISSING") . "\n";


echo "\n</pre>";
