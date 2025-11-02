<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Helpers\Validation;
use App\Models\Building;
use App\Models\Charge;
use App\Models\ChargeItem;
use App\Models\Unit;

class ChargeController extends AdminController
{
    /**
     * Display a list of all charges for a given building.
     */
    public function index($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) die('Building not found.');

        $charges = Charge::findByBuildingId($buildingId);
        require_once dirname(__DIR__) . '/../templates/charges/index.php';
    }

    /**
     * Show the form for creating a new charge.
     */
    public function create($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) die('Building not found.');

        require_once dirname(__DIR__) . '/../templates/charges/create.php';
    }

    /**
     * Store a new charge in the database.
     */
    public function store($buildingId)
    {
        Security::checkCsrf();

        $validator = new Validation($_POST);
        $validator->validate([
            'title' => 'required',
            'charge_month' => 'required',
            'due_date' => 'required',
            'total_amount' => 'required',
            'generation_method' => 'required',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            Helper::redirect("/admin/buildings/{$buildingId}/charges/create");
        }

        $units = Unit::findByBuildingId($buildingId);
        if (empty($units)) {
            $_SESSION['errors'] = ['general' => ['هیچ واحدی برای این ساختمان ثبت نشده است.']];
            Helper::redirect("/admin/buildings/{$buildingId}/charges/create");
        }

        $unitCharges = $this->calculateUnitCharges($units, $_POST['generation_method'], $_POST['total_amount']);

        $chargeData = [
            'building_id' => $buildingId,
            'title' => $_POST['title'],
            'charge_month' => $_POST['charge_month'],
            'due_date' => $_POST['due_date'],
            'generation_method' => $_POST['generation_method'],
            'total_amount' => $_POST['total_amount'],
            'created_by' => Auth::id(),
        ];

        if (Charge::createWithItems($chargeData, $unitCharges)) {
            $_SESSION['success'] = 'شارژ ماهانه با موفقیت ایجاد شد.';
            Helper::redirect("/admin/buildings/{$buildingId}/charges");
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ایجاد شارژ رخ داد.']];
            Helper::redirect("/admin/buildings/{$buildingId}/charges/create");
        }
    }

    /**
     * Show details of a specific charge, including all its items.
     */
    public function show($buildingId, $chargeId)
    {
        $charge = Charge::find($chargeId);
        if (!$charge || $charge->building_id != $buildingId) die('Charge not found.');

        $chargeItems = ChargeItem::findByChargeId($chargeId);
        require_once dirname(__DIR__) . '/../templates/charges/show.php';
    }

    /**
     * Calculate charge for each unit based on the selected method.
     */
    private function calculateUnitCharges($units, $method, $totalAmount)
    {
        $unitCharges = [];

        switch ($method) {
            case 'fixed':
                $amountPerUnit = $totalAmount / count($units);
                foreach ($units as $unit) {
                    $unitCharges[] = ['unit_id' => $unit->id, 'amount' => $amountPerUnit];
                }
                break;

            case 'by_area':
                $totalArea = array_reduce($units, fn($sum, $unit) => $sum + $unit->area, 0);
                if ($totalArea == 0) return []; // Avoid division by zero
                foreach ($units as $unit) {
                    $amount = ($unit->area / $totalArea) * $totalAmount;
                    $unitCharges[] = ['unit_id' => $unit->id, 'amount' => $amount];
                }
                break;

            case 'by_people':
                $totalPeople = array_reduce($units, fn($sum, $unit) => $sum + $unit->people_count, 0);
                if ($totalPeople == 0) return [];
                foreach ($units as $unit) {
                    $amount = ($unit->people_count / $totalPeople) * $totalAmount;
                    $unitCharges[] = ['unit_id' => $unit->id, 'amount' => $amount];
                }
                break;
        }

        return $unitCharges;
    }
}
