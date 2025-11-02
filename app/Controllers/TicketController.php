<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Models\Ticket;
use App\Models\Attachment;

class TicketController
{
    public function __construct()
    {
        // All ticket routes require a user to be logged in.
        if (!Auth::check()) {
            Helper::redirect('/login');
            exit();
        }
    }

    /**
     * Display a list of tickets.
     * Admins see all tickets, residents see only their own.
     */
    public function index()
    {
        if (Auth::hasRole('admin') || Auth::hasRole('manager')) {
            $tickets = Ticket::all();
        } else {
            $tickets = Ticket::findByUserId(Auth::id());
        }
        require_once dirname(__DIR__) . '/../templates/tickets/index.php';
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        require_once dirname(__DIR__) . '/../templates/tickets/create.php';
    }

    /**
     * Store a new ticket in the database.
     */
    public function store()
    {
        Security::checkCsrf();

        // Add validation here in a real application.

        $ticketData = [
            'user_id' => Auth::id(),
            'title' => $_POST['title'],
            'content' => $_POST['content'],
        ];

        $ticketId = Ticket::create($ticketData);

        if ($ticketId) {
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
                $this->handleUpload($ticketId, $_FILES['attachment']);
            }
            $_SESSION['success'] = 'تیکت با موفقیت ارسال شد.';
            Helper::redirect('/tickets');
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ارسال تیکت رخ داد.']];
            Helper::redirect('/tickets/create');
        }
    }

    /**
     * Update the status of a ticket (admin/manager only).
     */
    public function updateStatus($ticketId)
    {
        if (!Auth::hasRole('admin') && !Auth::hasRole('manager')) {
            die('Access Denied.');
        }

        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->updateStatus($_POST['status']);
            $_SESSION['success'] = 'وضعیت تیکت با موفقیت به‌روزرسانی شد.';
        }

        Helper::redirect('/tickets');
    }

    private function handleUpload($ticketId, $file)
    {
        $targetDir = "uploads/tickets/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        // You should add more robust validation (file type, size, etc.) here.
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            Attachment::create([
                'attachable_id' => $ticketId,
                'attachable_type' => 'ticket',
                'file_path' => $targetFile,
                'original_filename' => $file["name"],
                'mime_type' => $file['type'],
                'uploaded_by' => Auth::id(),
            ]);
        }
    }
}
