<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ChargeItem
{
    public $id;
    public $charge_id;
    public $unit_id;
    public $amount;
    public $status;

    /**
     * Find all charge items for a specific charge.
     *
     * @param int $chargeId
     * @return array
     */
    public static function findByChargeId($chargeId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare(
            'SELECT ci.*, u.number as unit_number, u.owner_name
             FROM charge_items ci
             JOIN units u ON ci.unit_id = u.id
             WHERE ci.charge_id = :charge_id'
        );
        $stmt->execute(['charge_id' => $chargeId]);
        // Fetches as an array of objects of the current class.
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Find all charge items for a specific unit.
     *
     * @param int $unitId
     * @return array
     */
    public static function findByUnitId($unitId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare(
            'SELECT ci.*, c.title as charge_title, c.charge_month, c.due_date
             FROM charge_items ci
             JOIN charges c ON ci.charge_id = c.id
             WHERE ci.unit_id = :unit_id
             ORDER BY c.charge_month DESC'
        );
        $stmt->execute(['unit_id' => $unitId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Update the status of a charge item.
     *
     * @param string $status
     * @return bool
     */
    public function updateStatus($status)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('UPDATE charge_items SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => $this->id]);
    }
}
