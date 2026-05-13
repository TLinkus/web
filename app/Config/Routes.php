<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::storeRegister');
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('companies/switch/(:num)', 'CompanyController::switch/$1', ['filter' => 'role:system_admin']);
    $routes->resource('companies', ['controller' => 'CompanyController', 'filter' => 'role:system_admin']);
    $routes->resource('users', ['controller' => 'UserController', 'filter' => 'role:system_admin,company_admin']);
    $routes->resource('lessons', ['controller' => 'LessonController']);
    $routes->get('diary/(:num)/edit', 'DiaryController::edit/$1', ['filter' => 'role:system_admin,company_admin,tutor']);
    $routes->post('diary/(:num)', 'DiaryController::update/$1', ['filter' => 'role:system_admin,company_admin,tutor']);
    $routes->get('logs', 'LogController::index', ['filter' => 'role:system_admin,company_admin']);
});
