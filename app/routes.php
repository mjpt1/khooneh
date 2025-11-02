<?php

// Routes for user authentication
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegisterForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Dashboard and Home
$router->get('/dashboard', 'DashboardController@index');
$router->get('/', 'HomeController@index');

// -----------------------------------------------------------------------------
// Admin Routes
// -----------------------------------------------------------------------------
// Building Management
$router->get('/admin/buildings', 'BuildingController@index');
$router->get('/admin/buildings/create', 'BuildingController@create');
$router->post('/admin/buildings/store', 'BuildingController@store');
$router->get('/admin/buildings/{id}/edit', 'BuildingController@edit');
$router->post('/admin/buildings/{id}/update', 'BuildingController@update');
$router->get('/admin/buildings/{id}/delete', 'BuildingController@destroy');

// Unit Management
$router->get('/admin/buildings/{buildingId}/units', 'UnitController@index');
$router->get('/admin/buildings/{buildingId}/units/create', 'UnitController@create');
$router->post('/admin/buildings/{buildingId}/units/store', 'UnitController@store');
$router->get('/admin/buildings/{buildingId}/units/{unitId}/edit', 'UnitController@edit');
$router->post('/admin/buildings/{buildingId}/units/{unitId}/update', 'UnitController@update');
$router->get('/admin/buildings/{buildingId}/units/{unitId}/delete', 'UnitController@destroy');

// Charge Management
$router->get('/admin/buildings/{buildingId}/charges', 'ChargeController@index');
$router->get('/admin/buildings/{buildingId}/charges/create', 'ChargeController@create');
$router->post('/admin/buildings/{buildingId}/charges/store', 'ChargeController@store');
$router->get('/admin/buildings/{buildingId}/charges/{chargeId}', 'ChargeController@show');

// Payment Management
$router->get('/admin/payments/create/{chargeItemId}', 'PaymentController@create');
$router->post('/admin/payments/store/{chargeItemId}', 'PaymentController@store');

// Reports (Admin Only)
$router->get('/admin/reports/outstanding-payments', 'ReportController@outstandingPayments');
$router->get('/admin/reports/fund-balance', 'ReportController@fundBalance');

// -----------------------------------------------------------------------------
// User-Facing Routes
// -----------------------------------------------------------------------------
// Online Payment (Mock)
$router->post('/payment/callback', 'PaymentController@callback');

// Ticketing System
$router->get('/tickets', 'TicketController@index');
$router->get('/tickets/create', 'TicketController@create');
$router->post('/tickets/store', 'TicketController@store');
$router->post('/tickets/{ticketId}/status', 'TicketController@updateStatus');

// Building Rules
$router->get('/rules', 'RuleController@index');
$router->get('/rules/create', 'RuleController@create'); // Admin
$router->post('/rules/store', 'RuleController@store');  // Admin
$router->get('/rules/{id}/edit', 'RuleController@edit'); // Admin
$router->post('/rules/{id}/update', 'RuleController@update'); // Admin
$router->get('/rules/{id}/delete', 'RuleController@destroy'); // Admin

// Chat System
$router->get('/chat', 'ChatController@index');
$router->get('/chat/with/{userId}', 'ChatController@show');
$router->post('/chat/store/{receiverId}', 'ChatController@store');

// Polls
$router->get('/polls', 'PollController@index');
$router->post('/polls/{pollId}/vote', 'PollController@vote');
$router->get('/polls/{pollId}/results', 'PollController@results');

// News
$router->get('/news', 'NewsController@index');
$router->get('/news/create', 'NewsController@create'); // Admin
$router->post('/news/store', 'NewsController@store');  // Admin
