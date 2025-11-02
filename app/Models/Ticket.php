<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Ticket
{
    public $id;
    public $user_id;
    public $title;
    public $content;
    public $status;
    public $created_at;
    public $updated_at;

    /**
     * Get all tickets.
     *
     * @return array
     */
    public static function all()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->query('SELECT t.*, u.full_name as user_name FROM tickets t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find all tickets for a specific user.
     *
     * @param int $userId
     * @return array
     */
    public static function findByUserId($userId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM tickets WHERE user_id = :user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find a ticket by its ID.
     *
     * @param int $id
     * @return Ticket|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new ticket.
     *
     * @param array $data
     * @return int|false The ID of the created ticket or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO tickets (user_id, title, content) VALUES (:user_id, :title, :content)";
        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Update the status of a ticket.
     *
     * @param string $status
     * @return bool
     */
    public function updateStatus($status)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('UPDATE tickets SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => $this->id]);
    }
}
