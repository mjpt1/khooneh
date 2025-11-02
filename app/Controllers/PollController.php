<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Models\Poll;

class PollController
{
    public function __construct()
    {
        if (!Auth::check()) Helper::redirect('/login');
    }

    /**
     * Display a list of active polls.
     */
    public function index()
    {
        $polls = Poll::getActivePolls();
        require_once dirname(__DIR__) . '/../templates/polls/index.php';
    }

    /**
     * Handle a user's vote.
     */
    public function vote($pollId)
    {
        $option = $_POST['option'];
        Poll::vote($pollId, Auth::id(), $option);
        Helper::redirect("/polls/{$pollId}/results");
    }

    /**
     * Display the results of a poll.
     */
    public function results($pollId)
    {
        $poll = Poll::find($pollId);
        $results = Poll::getResults($pollId);
        require_once dirname(__DIR__) . '/../templates/polls/results.php';
    }

    // Admin-specific methods for creating polls would go here.
}
