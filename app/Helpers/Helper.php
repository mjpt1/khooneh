<?php

namespace App\Helpers;

class Helper
{
    /**
     * Dumps a variable and dies.
     *
     * @param mixed $data
     */
    public static function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

    /**
     * Sanitizes a string, removing tags and extra spaces.
     *
     * @param string $input
     * @return string
     */
    public static function sanitizeString($input)
    {
        return trim(strip_tags($input));
    }

    /**
     * Escapes HTML for safe output.
     *
     * @param string $string
     * @return string
     */
    public static function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Redirects to a given path.
     *
     * @param string $path
     */
    public static function redirect($path)
    {
        header("Location: {$path}");
        exit();
    }

    /**
     * Returns the base URL of the application.
     *
     * @return string
     */
    public static function baseUrl()
    {
        // This is a simple implementation. A more robust one might read from a config file.
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
    }
}
