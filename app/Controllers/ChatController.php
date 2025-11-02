<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Models\Message;
use App\Models\User;

class ChatController
{
    public function __construct()
    {
        if (!Auth::check()) Helper::redirect('/login');
    }

    /**
     * Display the list of chats for the manager, or the chat interface for a resident.
     */
    public function index()
    {
        if (Auth::hasRole('manager')) {
            // Manager sees a list of users they can chat with.
            $users = User::all(); // You'd likely refine this to show only residents.
            require_once dirname(__DIR__) . '/../templates/chat/manager_index.php';
        } else {
            // Resident is taken directly to their chat with the manager.
            // You need a way to find the manager's ID. Let's assume it's user ID 1 for now.
            $managerId = 1;
            Helper::redirect("/chat/with/{$managerId}");
        }
    }

    /**
     * Display the chat history with a specific user.
     */
    public function show($withUserId)
    {
        $messages = Message::getChatHistory(Auth::id(), $withUserId);
        $chatWithUser = User::find($withUserId);
        require_once dirname(__DIR__) . '/../templates/chat/show.php';
    }

    /**
     * Send a new message.
     */
    public function store($receiverId)
    {
        Message::create(Auth::id(), $receiverId, $_POST['content']);
        Helper::redirect("/chat/with/{$receiverId}");
    }
}
