<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Helpers\Validation;
use App\Models\User;

class AuthController
{
    /**
     * Show the login page.
     */
    public function showLoginForm()
    {
        // In a real app, you would use a templating engine.
        // For simplicity, we'll just require the view file.
        require_once dirname(__DIR__) . '/../templates/auth/login.php';
    }

    /**
     * Show the registration page.
     */
    public function showRegisterForm()
    {
        require_once dirname(__DIR__) . '/../templates/auth/register.php';
    }

    /**
     * Handle user login.
     */
    public function login()
    {
        Security::checkCsrf();

        $validator = new Validation($_POST);
        $validator->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // Store errors in session to display them on the login page
            $_SESSION['errors'] = $validator->getErrors();
            Helper::redirect('/login');
        }

        if (Auth::attempt($_POST['username'], $_POST['password'])) {
            Helper::redirect('/dashboard');
        } else {
            $_SESSION['errors'] = ['login' => ['نام کاربری یا رمز عبور اشتباه است.']];
            Helper::redirect('/login');
        }
    }

    /**
     * Handle user registration.
     */
    public function register()
    {
        Security::checkCsrf();

        $validator = new Validation($_POST);
        $validator->validate([
            'full_name' => 'required|min:3',
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['old'] = $_POST; // Preserve old input
            Helper::redirect('/register');
        }

        // Check for unique username/email
        if (User::findByUsernameOrEmail($_POST['username']) || User::findByUsernameOrEmail($_POST['email'])) {
            $_SESSION['errors'] = ['register' => ['نام کاربری یا ایمیل قبلاً ثبت شده است.']];
            $_SESSION['old'] = $_POST;
            Helper::redirect('/register');
        }

        $userId = User::create([
            'full_name' => $_POST['full_name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        if ($userId) {
            // Optionally, log the user in directly after registration
            $user = User::find($userId);
            Auth::login($user);
            Helper::redirect('/dashboard');
        } else {
            $_SESSION['errors'] = ['register' => ['خطایی در هنگام ثبت‌نام رخ داد.']];
            Helper::redirect('/register');
        }
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        Auth::logout();
        Helper::redirect('/login');
    }
}
