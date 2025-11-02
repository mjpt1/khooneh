<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class News
{
    public $id;
    public $title;
    public $content;
    public $created_by;
    public $created_at;

    /**
     * Get all news items.
     *
     * @return array
     */
    public static function all()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->query('SELECT n.*, u.full_name as author_name FROM news n JOIN users u ON n.created_by = u.id ORDER BY n.created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Create a new news item.
     *
     * @param array $data
     * @return int|false The ID of the created news item or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO news (title, content, created_by) VALUES (:title, :content, :created_by)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'created_by' => $data['created_by'],
        ]) ? $pdo->lastInsertId() : false;
    }
}
