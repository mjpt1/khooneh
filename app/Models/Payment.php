<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Payment
{
    public $id;
    public $charge_item_id;
    public $user_id;
    public $amount;
    public $payment_method;
    public $transaction_ref;
    public $status;
    public $paid_at;
    public $verified_by;
    public $created_at;

    /**
     * Create a new payment and update the corresponding charge item.
     *
     * @param array $data
     * @return int|false The ID of the created payment or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();

        try {
            $pdo->beginTransaction();

            // 1. Create the payment record
            $sql = "INSERT INTO payments (charge_item_id, user_id, amount, payment_method, transaction_ref, status, paid_at, verified_by)
                    VALUES (:charge_item_id, :user_id, :amount, :payment_method, :transaction_ref, :status, :paid_at, :verified_by)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'charge_item_id' => $data['charge_item_id'],
                'user_id' => $data['user_id'],
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'transaction_ref' => $data['transaction_ref'] ?? null,
                'status' => $data['status'] ?? 'completed',
                'paid_at' => $data['paid_at'],
                'verified_by' => $data['verified_by'] ?? null,
            ]);
            $paymentId = $pdo->lastInsertId();

            // 2. Update the status of the charge_item to 'paid'
            if ($data['status'] === 'completed') {
                $stmtUpdate = $pdo->prepare('UPDATE charge_items SET status = "paid" WHERE id = :id');
                $stmtUpdate->execute(['id' => $data['charge_item_id']]);
            }

            $pdo->commit();
            return $paymentId;

        } catch (\Exception $e) {
            $pdo->rollBack();
            // In a real app, log the error.
            // error_log($e->getMessage());
            return false;
        }
    }
}
