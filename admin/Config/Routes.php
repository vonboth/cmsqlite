<?php


use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = \Config\Services::routes(true);

$routes->group(
    'admin',
    ['namespace' => 'Admin\Controllers'],
    function (RouteCollection $routes) {
        $routes->get('authenticate/login', 'Authenticate::login');
        $routes->post('authenticate/login', 'Authenticate::authenticate');
        $routes->get('authenticate/logout', 'Authenticate::logout');
        $routes->add('/', 'Home::index');
        $routes->add('home', 'Home::index');
    }
);

$routes->get('(:any)', 'Home::index/$1');