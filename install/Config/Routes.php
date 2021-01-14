<?php

use Config\Services;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes(true);

$routes->group(
    'install',
    ['namespace' => 'Install\Controllers'],
    function(RouteCollection $routes) {
        $routes->post('/', 'Index::install');
        $routes->add('/', 'Index::index');
    }
);
