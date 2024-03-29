<?php

use Config\Services;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes(true);

$routes->group(
    'install',
    ['namespace' => 'Install\Controllers'],
    function(RouteCollection $routes) {
        $routes->post('/', 'IndexController::install');
        $routes->add('/', 'IndexController::index');
    }
);
