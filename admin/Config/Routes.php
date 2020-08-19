<?php


use CodeIgniter\Router\RouteCollection;
use Config\Services;

/** @var RouteCollection $routes */
$routes = Services::routes(true);

$routes->group(
    'admin',
    ['namespace' => 'Admin\Controllers'],
    function (RouteCollection $routes) {
        $routes->get('authenticate/login', 'Authenticate::login');
        $routes->post('authenticate/login', 'Authenticate::authenticate');
        $routes->get('authenticate/logout', 'Authenticate::logout');
        $routes->add('/', 'Start::index');
        $routes->add('start', 'Start::index');
        $routes->group(
            'articles',
            function (RouteCollection $routes) {
                $routes->add('index', 'Articles::index');
                $routes->add('add', 'Articles::add');
                $routes->add('edit/(:num)', 'Articles::edit/$1');
                $routes->add('view/(:num)', 'Articles::view/$1');
                $routes->add('delete/(:num)', 'Articles::delete/$1');
                $routes->add('/', 'Articles::index');
            }
        );
        $routes->group(
            'categories',
            function (RouteCollection $routes) {
                $routes->add('index', 'Categories::index');
                $routes->add('add', 'Categories::add');
                $routes->add('edit/(:num)', 'Categories::edit/$1');
                $routes->add('view/(:num)', 'Categories::view/$1');
                $routes->add('delete/(:num)', 'Categories::delete/$1');
                $routes->add('/', 'Categories::index');
            }
        );
        $routes->group(
            'menus',
            function (RouteCollection $routes) {
                $routes->add('index', 'Menus::index');
                $routes->add('add', 'Menus::add');
                $routes->add('edit/(:num)', 'Menus::edit/$1');
                $routes->add('view/(:num)', 'Menus::view/$1');
                $routes->add('delete/(:num)', 'Menus::delete/$1');
                $routes->add('/', 'Menus::index');
            }
        );
        /*$routes->group(
            'menuresource',
            function (RouteCollection $routes) {
                $routes->get('index', '\Admin\Controllers\Resource\Menus::index');
                $routes->get('show/(:num)', '\Admin\Controllers\Resource\Menus::show/$1');
                $routes->post('create', '\Admin\Controllers\Resource\Menus::create');
                $routes->post('update/(:num)', '\Admin\Controllers\Resource\Menus::update/$1');
                $routes->post('delete/(:num)', '\Admin\Controllers\Resource\Menus::delete/$1');
                $routes->get('/', '\Admin\Controllers\Resource\Menus::index');
            }
        );*/
        $routes->group(
            'users',
            function (RouteCollection $routes) {
                $routes->add('index', 'Users::index');
                $routes->add('add', 'Users::add');
                $routes->add('edit/(:num)', 'Users::edit/$1');
                $routes->add('view/(:num)', 'Users::view/$1');
                $routes->add('delete/(:num)', 'Users::delete/$1');
                $routes->add('/', 'Users::index');
            }
        );
    }
);
