<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Unit
{
    public $id;
    public $building_id;
    public $block;
    public $floor;
    public $number;
    public $area;
    public $people_count;
    public $owner_name;
    public $created_at;
    public $updated_at;

    /**
     * Get all units for a specific building.
     *
     * @param int $buildingId
     * @return array
     */
    public static function findByBuildingId($buildingId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM units WHERE building_id = :building_id ORDER BY floor, number');
        $stmt->execute(['building_id' => $buildingId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find a unit by its ID.
     *
     * @param int $id
     * @return Unit|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM units WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new unit.
     *
     * @param array $data
     * @return int|false The ID of the created unit or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO units (building_id, block, floor, number, area, people_count, owner_name)
                VALUES (:building_id, :block, :floor, :number, :area, :people_count, :owner_name)";
        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            'building_id' => $data['building_id'],
            'block' => $data['block'],
            'floor' => $data['floor'],
            'number' => $data['number'],
            'area' => $data['area'],
            'people_count' => $data['people_count'],
            'owner_name' => $data['owner_name'],
        ]);

        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Update a unit.
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "UPDATE units SET block = :block, floor = :floor, number = :number,
                area = :area, people_count = :people_count, owner_name = :owner_name
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'id' => $this->id,
            'block' => $data['block'],
            'floor' => $data['floor'],
            'number' => $data['number'],
            'area' => $data['area'],
            'people_count' => $data['people_count'],
            'owner_name' => $data['owner_name'],
        ]);
    }

    /**
     * Delete a unit.
     *
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('DELETE FROM units WHERE id = :id');
        return $stmt->execute(['id' => $this->id]);
    }
}
