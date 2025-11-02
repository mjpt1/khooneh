<?php

namespace App\Helpers;

class Security
{
    /**
     * Generate a CSRF token and store it in the session.
     *
     * @return string
     */
    public static function generateCsrfToken()
    {
        Auth::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Get the CSRF token from the session.
     *
     * @return string|null
     */
    public static function getCsrfToken()
    {
        Auth::start();
        return $_SESSION['csrf_token'] ?? null;
    }

    /**
     * Verify the CSRF token.
     *
     * @param string $token
     * @return bool
     */
    public static function verifyCsrfToken($token)
    {
        Auth::start();
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            // Token is valid, unset it to prevent reuse (optional, but good practice for some scenarios)
            // unset($_SESSION['csrf_token']);
            return true;
        }
        return false;
    }

    /**
     * Generate a hidden input field for the CSRF token.
     *
     * @return string
     */
    public static function csrfField()
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Middleware-like function to check CSRF token for POST requests.
     * To be called at the beginning of POST route handling.
     */
    public static function checkCsrf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!self::verifyCsrfToken($token)) {
                // Handle invalid token - e.g., show an error page
                http_response_code(403);
                die('خطای امنیتی: توکن CSRF نامعتبر است.');
            }
        }
    }
}
