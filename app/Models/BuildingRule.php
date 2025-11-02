<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class BuildingRule
{
    public $id;
    public $title;
    public $content;
    public $created_by;
    public $created_at;
    public $updated_at;

    /**
     * Get all rules.
     *
     * @return array
     */
    public static function all()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->query('SELECT * FROM building_rules ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find a rule by its ID.
     *
     * @param int $id
     * @return BuildingRule|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM building_rules WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Search for rules by a keyword.
     *
     * @param string $query
     * @return array
     */
    public static function search($query)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM building_rules WHERE title LIKE :query OR content LIKE :query');
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Create a new rule.
     *
     * @param array $data
     * @return int|false The ID of the created rule or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO building_rules (title, content, created_by) VALUES (:title, :content, :created_by)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'created_by' => $data['created_by'],
        ]) ? $pdo->lastInsertId() : false;
    }

    /**
     * Update a rule.
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "UPDATE building_rules SET title = :title, content = :content WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'id' => $this->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    /**
     * Delete a rule.
     *
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('DELETE FROM building_rules WHERE id = :id');
        return $stmt->execute(['id' => $this->id]);
    }
}
