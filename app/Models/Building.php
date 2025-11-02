<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Building
{
    public $id;
    public $title;
    public $address;
    public $created_at;
    public $updated_at;

    /**
     * Get all buildings.
     *
     * @return array
     */
    public static function all()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->query('SELECT * FROM buildings ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find a building by its ID.
     *
     * @param int $id
     * @return Building|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM buildings WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new building.
     *
     * @param array $data
     * @return int|false The ID of the created building or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO buildings (title, address) VALUES (:title, :address)";
        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            'title' => $data['title'],
            'address' => $data['address'],
        ]);

        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Update a building.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "UPDATE buildings SET title = :title, address = :address WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'id' => $this->id,
            'title' => $data['title'],
            'address' => $data['address'],
        ]);
    }

    /**
     * Delete a building.
     *
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('DELETE FROM buildings WHERE id = :id');
        return $stmt->execute(['id' => $this->id]);
    }
}
