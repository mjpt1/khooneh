<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;

class HomeController
{
    public function index()
    {
        if (Auth::check()) {
            Helper::redirect('/dashboard');
        } else {
            Helper::redirect('/login');
        }
    }
}
