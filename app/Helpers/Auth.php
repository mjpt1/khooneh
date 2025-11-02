<?php

namespace App\Helpers;

use App\Models\User;

class Auth
{
    /**
     * Start the session if it's not already started.
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            // Configure session parameters for better security
            session_set_cookie_params([
                'lifetime' => 1800, // 30 minutes
                'path' => '/',
                'domain' => '', // Set your domain in production
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    /**
     * Check if a user is logged in.
     *
     * @return bool
     */
    public static function check()
    {
        self::start();
        return isset($_SESSION['user_id']);
    }

    /**
     * Get the logged-in user.
     *
     * @return User|null
     */
    public static function user()
    {
        if (!self::check()) {
            return null;
        }

        // In a real application, you might fetch a fresh user object from the DB.
        // For simplicity, we can store the user object in the session.
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
            return $_SESSION['user'];
        }

        // Fallback to fetch from DB
        return User::find($_SESSION['user_id']);
    }

    /**
     * Get the ID of the logged-in user.
     *
     * @return int|null
     */
    public static function id()
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Attempt to log in a user.
     *
     * @param string $usernameOrEmail
     * @param string $password
     * @return bool
     */
    public static function attempt($usernameOrEmail, $password)
    {
        $user = User::findByUsernameOrEmail($usernameOrEmail);

        if ($user && password_verify($password, $user->password)) {
            self::login($user);
            return true;
        }

        return false;
    }

    /**
     * Log in a user.
     *
     * @param User $user
     */
    public static function login(User $user)
    {
        self::start();
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user'] = $user; // Optionally store the whole user object
    }

    /**
     * Log out the user.
     */
    public static function logout()
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Check if the logged-in user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public static function hasRole($role)
    {
        if (!self::check()) {
            return false;
        }

        return ($_SESSION['user_role'] === $role);
    }
}
