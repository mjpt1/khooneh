<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Models\ChargeItem;
use App\Models\News;
use App\Models\Poll;

class DashboardController
{
    public function __construct()
    {
        if (!Auth::check()) {
            Helper::redirect('/login');
            exit();
        }
    }

    public function index()
    {
        $user = Auth::user();

        $latestCharges = ChargeItem::findByUnitId($user->unit_id);
        $latestNews = News::all(); // You might want to limit this to the top 5 or so
        $activePolls = Poll::getActivePolls();

        require_once dirname(__DIR__) . '/../templates/dashboard/index.php';
    }
}
