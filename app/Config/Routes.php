<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'PagesController::start', ['priority' => 1]);
$routes->get('pages/([a-z0-9_-]+)', 'PagesController::pages/$1', ['priority' => 1]);
$routes->get('{locale}/', 'PagesController::start', ['priority' => 2]);
$routes->get('{locale}/pages/([a-z0-9_-]+)', 'PagesController::pages/$1', ['priority' => 1]);
$routes->get('language', 'LanguageController::index', ['priority' => 1]);
//$routes->get('/([a-z_-]+[^admin][^install][^maintenance])', 'PagesController::pages/$1');
$routes->get('maintenance', 'MaintenanceController::index', ['as' => 'maintenance', 'priority' => 1]);

