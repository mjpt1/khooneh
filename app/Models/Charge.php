<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Charge
{
    public $id;
    public $building_id;
    public $title;
    public $charge_month;
    public $due_date;
    public $generation_method;
    public $total_amount;
    public $created_by;
    public $created_at;

    /**
     * Get all charges for a specific building.
     *
     * @param int $buildingId
     * @return array
     */
    public static function findByBuildingId($buildingId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM charges WHERE building_id = :building_id ORDER BY charge_month DESC');
        $stmt->execute(['building_id' => $buildingId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find a charge by its ID.
     *
     * @param int $id
     * @return Charge|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM charges WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new charge and its associated items in a transaction.
     *
     * @param array $data
     * @param array $unitCharges Array of ['unit_id' => x, 'amount' => y]
     * @return int|false The ID of the created charge or false on failure.
     */
    public static function createWithItems(array $data, array $unitCharges)
    {
        $pdo = Database::getPdo();

        try {
            $pdo->beginTransaction();

            // 1. Create the main charge record
            $sqlCharge = "INSERT INTO charges (building_id, title, charge_month, due_date, generation_method, total_amount, created_by)
                          VALUES (:building_id, :title, :charge_month, :due_date, :generation_method, :total_amount, :created_by)";
            $stmtCharge = $pdo->prepare($sqlCharge);
            $stmtCharge->execute([
                'building_id' => $data['building_id'],
                'title' => $data['title'],
                'charge_month' => $data['charge_month'],
                'due_date' => $data['due_date'],
                'generation_method' => $data['generation_method'],
                'total_amount' => $data['total_amount'],
                'created_by' => $data['created_by'],
            ]);
            $chargeId = $pdo->lastInsertId();

            // 2. Create the charge items for each unit
            $sqlItems = "INSERT INTO charge_items (charge_id, unit_id, amount) VALUES (:charge_id, :unit_id, :amount)";
            $stmtItems = $pdo->prepare($sqlItems);

            foreach ($unitCharges as $item) {
                $stmtItems->execute([
                    'charge_id' => $chargeId,
                    'unit_id' => $item['unit_id'],
                    'amount' => $item['amount'],
                ]);
            }

            $pdo->commit();
            return $chargeId;

        } catch (\Exception $e) {
            $pdo->rollBack();
            // In a real app, you should log the error: error_log($e->getMessage());
            return false;
        }
    }
}
