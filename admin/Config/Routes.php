<?php

$routes = \Config\Services::routes(true);

$routes->group('admin', ['namespace' => 'Admin\Controllers'], function($routes) {
    $routes->get('/', 'Index::index');
});