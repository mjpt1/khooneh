<?php

namespace App\Controllers;

use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\Helper;

class ReportController extends AdminController
{
    /**
     * Display a report of all unpaid charge items.
     */
    public function outstandingPayments()
    {
        $pdo = Database::getPdo();
        $sql = 'SELECT ci.*, u.number as unit_number, u.owner_name, c.title as charge_title
                FROM charge_items ci
                JOIN units u ON ci.unit_id = u.id
                JOIN charges c ON ci.charge_id = c.id
                WHERE ci.status = "unpaid"
                ORDER BY c.due_date ASC';
        $stmt = $pdo->query($sql);
        $unpaidItems = $stmt->fetchAll();

        require_once dirname(__DIR__) . '/../templates/reports/outstanding_payments.php';
    }

    /**
     * Display a report of the building's financial balance.
     */
    public function fundBalance()
    {
        $pdo = Database::getPdo();

        // This is a simplified calculation. A real accounting system would be more complex.
        $totalIncome = $pdo->query('SELECT SUM(amount) FROM payments WHERE status = "completed"')->fetchColumn();
        $totalCharges = $pdo->query('SELECT SUM(total_amount) FROM charges')->fetchColumn();

        $balance = $totalIncome - $totalCharges; // Or however you define balance.

        require_once dirname(__DIR__) . '/../templates/reports/fund_balance.php';
    }
}
