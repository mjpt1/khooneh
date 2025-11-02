<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Helpers\Security;
use App\Helpers\Validation;
use App\Models\Building;

class BuildingController extends AdminController
{
    /**
     * Display a list of all buildings.
     */
    public function index()
    {
        $buildings = Building::all();
        require_once dirname(__DIR__) . '/../templates/buildings/index.php';
    }

    /**
     * Show the form for creating a new building.
     */
    public function create()
    {
        require_once dirname(__DIR__) . '/../templates/buildings/create.php';
    }

    /**
     * Store a new building in the database.
     */
    public function store()
    {
        Security::checkCsrf();

        $validator = new Validation($_POST);
        $validator->validate([
            'title' => 'required|min:3',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['old'] = $_POST;
            Helper::redirect('/admin/buildings/create');
        }

        if (Building::create($_POST)) {
            $_SESSION['success'] = 'ساختمان با موفقیت ایجاد شد.';
            Helper::redirect('/admin/buildings');
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ایجاد ساختمان رخ داد.']];
            Helper::redirect('/admin/buildings/create');
        }
    }

    /**
     * Show the form for editing a building.
     */
    public function edit($id)
    {
        $building = Building::find($id);
        if (!$building) {
            http_response_code(404);
            die('Building not found.');
        }
        require_once dirname(__DIR__) . '/../templates/buildings/edit.php';
    }

    /**
     * Update a building in the database.
     */
    public function update($id)
    {
        Security::checkCsrf();

        $building = Building::find($id);
        if (!$building) {
            http_response_code(404);
            die('Building not found.');
        }

        $validator = new Validation($_POST);
        $validator->validate([
            'title' => 'required|min:3',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['old'] = $_POST;
            Helper::redirect("/admin/buildings/{$id}/edit");
        }

        if ($building->update($_POST)) {
            $_SESSION['success'] = 'ساختمان با موفقیت ویرایش شد.';
            Helper::redirect('/admin/buildings');
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ویرایش ساختمان رخ داد.']];
            Helper::redirect("/admin/buildings/{$id}/edit");
        }
    }

    /**
     * Delete a building from the database.
     */
    public function destroy($id)
    {
        // Note: CSRF protection for DELETE is often done via a form with a POST request.
        // For simplicity here, we assume a GET request, but a real app should use a form.
        $building = Building::find($id);
        if ($building) {
            $building->delete();
            $_SESSION['success'] = 'ساختمان با موفقیت حذف شد.';
        }

        Helper::redirect('/admin/buildings');
    }
}
