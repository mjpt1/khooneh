<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Message
{
    public $id;
    public $sender_id;
    public $receiver_id;
    public $content;
    public $is_read;
    public $created_at;

    /**
     * Get the chat history between two users.
     *
     * @param int $user1Id
     * @param int $user2Id
     * @return array
     */
    public static function getChatHistory($user1Id, $user2Id)
    {
        $pdo = Database::getPdo();
        $sql = 'SELECT m.*, u.full_name as sender_name
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE (sender_id = :user1 AND receiver_id = :user2)
                   OR (sender_id = :user2 AND receiver_id = :user1)
                ORDER BY created_at ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user1' => $user1Id, 'user2' => $user2Id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Create a new message.
     *
     * @param int $senderId
     * @param int $receiverId
     * @param string $content
     * @return bool
     */
    public static function create($senderId, $receiverId, $content)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (:sender_id, :receiver_id, :content)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content,
        ]);
    }
}
