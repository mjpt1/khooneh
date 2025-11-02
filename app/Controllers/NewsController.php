<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Models\News;

class NewsController
{
    /**
     * Display a list of all news items.
     */
    public function index()
    {
        if (!Auth::check()) Helper::redirect('/login');
        $news = News::all();
        require_once dirname(__DIR__) . '/../templates/news/index.php';
    }

    /**
     * Show the form for creating a new news item (admin only).
     */
    public function create()
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        require_once dirname(__DIR__) . '/../templates/news/create.php';
    }

    /**
     * Store a new news item in the database (admin only).
     */
    public function store()
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        Security::checkCsrf();

        News::create([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'created_by' => Auth::id(),
        ]);

        Helper::redirect('/news');
    }
}
