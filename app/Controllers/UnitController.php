<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Helpers\Security;
use App\Helpers\Validation;
use App\Models\Building;
use App\Models\Unit;

class UnitController extends AdminController
{
    /**
     * Display a list of all units for a given building.
     */
    public function index($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) {
            http_response_code(404);
            die('Building not found.');
        }

        $units = Unit::findByBuildingId($buildingId);
        require_once dirname(__DIR__) . '/../templates/units/index.php';
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) {
            http_response_code(404);
            die('Building not found.');
        }
        require_once dirname(__DIR__) . '/../templates/units/create.php';
    }

    /**
     * Store a new unit in the database.
     */
    public function store($buildingId)
    {
        Security::checkCsrf();

        $validator = new Validation($_POST);
        $validator->validate([
            'number' => 'required',
            'floor' => 'required',
            'area' => 'required',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['old'] = $_POST;
            Helper::redirect("/admin/buildings/{$buildingId}/units/create");
        }

        $_POST['building_id'] = $buildingId;

        if (Unit::create($_POST)) {
            $_SESSION['success'] = 'واحد با موفقیت ایجاد شد.';
            Helper::redirect("/admin/buildings/{$buildingId}/units");
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ایجاد واحد رخ داد.']];
            Helper::redirect("/admin/buildings/{$buildingId}/units/create");
        }
    }

    /**
     * Show the form for editing a unit.
     */
    public function edit($buildingId, $unitId)
    {
        $unit = Unit::find($unitId);
        if (!$unit || $unit->building_id != $buildingId) {
            http_response_code(404);
            die('Unit not found.');
        }
        require_once dirname(__DIR__) . '/../templates/units/edit.php';
    }

    /**
     * Update a unit in the database.
     */
    public function update($buildingId, $unitId)
    {
        Security::checkCsrf();

        $unit = Unit::find($unitId);
        if (!$unit || $unit->building_id != $buildingId) {
            http_response_code(404);
            die('Unit not found.');
        }

        $validator = new Validation($_POST);
        $validator->validate([
            'number' => 'required',
            'floor' => 'required',
            'area' => 'required',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['old'] = $_POST;
            Helper::redirect("/admin/buildings/{$buildingId}/units/{$unitId}/edit");
        }

        if ($unit->update($_POST)) {
            $_SESSION['success'] = 'واحد با موفقیت ویرایش شد.';
            Helper::redirect("/admin/buildings/{$buildingId}/units");
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ویرایش واحد رخ داد.']];
            Helper::redirect("/admin/buildings/{$buildingId}/units/{$unitId}/edit");
        }
    }

    /**
     * Delete a unit from the database.
     */
    public function destroy($buildingId, $unitId)
    {
        $unit = Unit::find($unitId);
        if ($unit && $unit->building_id == $buildingId) {
            $unit->delete();
            $_SESSION['success'] = 'واحد با موفقیت حذف شد.';
        }

        Helper::redirect("/admin/buildings/{$buildingId}/units");
    }
}
