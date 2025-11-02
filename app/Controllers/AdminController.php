<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;

class AdminController
{
    /**
     * AdminController constructor.
     *
     * This acts as a middleware to protect all admin routes.
     * Any controller that extends this will automatically be protected.
     */
    public function __construct()
    {
        // First, check if the user is logged in at all.
        if (!Auth::check()) {
            Helper::redirect('/login');
            exit();
        }

        // Then, check if the user has the 'admin' role.
        if (!Auth::hasRole('admin')) {
            // You might want to redirect to a specific 'unauthorized' page.
            // For now, redirecting to the dashboard is a safe default.
            http_response_code(403);
            die('Access Denied. You do not have permission to view this page.');
        }
    }
}
