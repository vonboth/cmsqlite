<?php


use CodeIgniter\Router\RouteCollection;
use Config\Services;

/** @var RouteCollection $routes */
$routes = Services::routes(true);

$routes->group(
    'admin',
    ['namespace' => 'Admin\Controllers'],
    function (RouteCollection $routes) {
        $routes->add('/', 'Start::index');
        $routes->add('start', 'Start::index');
        $routes->group('authenticate', function(RouteCollection $routes) {
            $routes->add('login', 'Authenticate::login');
            $routes->get('logout', 'Authenticate::logout');
        });
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
                $routes->add('view/(:num)', 'Menus::index');
                $routes->add('delete/(:num)', 'Menus::delete/$1');
                $routes->add('/', 'Menus::index');
            }
        );
        $routes->group(
            'menuitems',
            function (RouteCollection $routes) {
                $routes->add('index', 'Menus::index');
                $routes->add('add', 'Menuitems::add');
                $routes->add('edit/(:num)', 'Menuitems::edit/$1');
                $routes->add('view/(:num)', 'Menus::index');
                $routes->add('delete/(:num)', 'Menuitems::delete/$1');
                $routes->add('moveup/(:num)', 'Menuitems::moveup/$1');
                $routes->add('movedown/(:num)', 'Menuitems::movedown/$1');
                $routes->add('/', 'Menus::index');
            }
        );
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
        $routes->group(
            'profile',
            function(RouteCollection $routes) {
                $routes->get('index', 'Profile::edit');
                $routes->add('edit', 'Profile::edit');
                $routes->add('/', 'Profile::edit');
            }
        );
        $routes->group(
            'media',
            function(RouteCollection $routes) {
                $routes->add('index', 'Media::index');
                $routes->post('upload', 'Media::upload');
                $routes->post('remove', 'Media::remove');
                $routes->add('/', 'Media::index');
            }
        );
    }
);
