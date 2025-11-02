<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Models\BuildingRule;

class RuleController
{
    /**
     * Display a list of all rules.
     * Handles search functionality.
     */
    public function index()
    {
        if (!Auth::check()) Helper::redirect('/login');

        $searchQuery = $_GET['q'] ?? null;
        if ($searchQuery) {
            $rules = BuildingRule::search($searchQuery);
        } else {
            $rules = BuildingRule::all();
        }

        require_once dirname(__DIR__) . '/../templates/rules/index.php';
    }

    /**
     * Show the form for creating a new rule (admin only).
     */
    public function create()
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        require_once dirname(__DIR__) . '/../templates/rules/create.php';
    }

    /**
     * Store a new rule in the database (admin only).
     */
    public function store()
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        Security::checkCsrf();

        BuildingRule::create([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'created_by' => Auth::id(),
        ]);

        Helper::redirect('/rules');
    }

    /**
     * Show the form for editing a rule (admin only).
     */
    public function edit($id)
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        $rule = BuildingRule::find($id);
        require_once dirname(__DIR__) . '/../templates/rules/edit.php';
    }

    /**
     * Update a rule (admin only).
     */
    public function update($id)
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');
        Security::checkCsrf();

        $rule = BuildingRule::find($id);
        if ($rule) {
            $rule->update($_POST);
        }

        Helper::redirect('/rules');
    }

    /**
     * Delete a rule (admin only).
     */
    public function destroy($id)
    {
        if (!Auth::hasRole('admin')) die('Access Denied.');

        $rule = BuildingRule::find($id);
        if ($rule) {
            $rule->delete();
        }

        Helper::redirect('/rules');
    }
}
