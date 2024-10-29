<?php


use CodeIgniter\Router\RouteCollection;
use Config\Services;

/** @var RouteCollection $routes */
$routes = Services::routes(true);

$routes->group(
    'admin',
    ['namespace' => 'Admin\Controllers'],
    static function (RouteCollection $routes) {
        $routes->add('/', 'StartController::index', ['priority' => 0]);
        $routes->group(
            'start',
            static function (RouteCollection $routes) {
                $routes->add('index', 'StartController::index');
                $routes->add('reset-hits', 'StartController::resetHits');
                $routes->add('/', 'StartController::index');
            }
        );
        $routes->group(
            'authenticate',
            static function (RouteCollection $routes) {
                $routes->add('login', 'AuthenticateController::login');
                $routes->get('logout', 'AuthenticateController::logout');
            }
        );
        $routes->group(
            'articles',
            static function (RouteCollection $routes) {
                $routes->add('index', 'ArticlesController::index');
                $routes->add('add', 'ArticlesController::add');
                $routes->add('edit/(:num)', 'ArticlesController::edit/$1');
                $routes->add('view/(:num)', 'ArticlesController::view/$1');
                $routes->add('delete/(:num)', 'ArticlesController::delete/$1');
                $routes->add('/', 'ArticlesController::index');
            }
        );
        $routes->group(
            'categories',
            static function (RouteCollection $routes) {
                $routes->add('index', 'CategoriesController::index');
                $routes->add('add', 'CategoriesController::add');
                $routes->add('edit/(:num)', 'CategoriesController::edit/$1');
                $routes->add('view/(:num)', 'CategoriesController::view/$1');
                $routes->add('delete/(:num)', 'CategoriesController::delete/$1');
                $routes->add('/', 'CategoriesController::index');
            }
        );
        $routes->group(
            'menus',
            static function (RouteCollection $routes) {
                $routes->add('index', 'MenusController::index');
                $routes->add('add', 'MenusController::add');
                $routes->add('edit/(:num)', 'MenusController::edit/$1');
                $routes->add('view/(:num)', 'MenusController::index');
                $routes->add('delete/(:num)', 'MenusController::delete/$1');
                $routes->add('/', 'MenusController::index');
            }
        );
        $routes->group(
            'menuitems',
            static function (RouteCollection $routes) {
                $routes->add('index', 'MenusController::index');
                $routes->add('add', 'MenuitemsController::add');
                $routes->add('edit/(:num)', 'MenuitemsController::edit/$1');
                $routes->add('view/(:num)', 'MenusController::index');
                $routes->add('delete/(:num)', 'MenuitemsController::delete/$1');
                $routes->add('move/(:num)', 'MenuitemsController::move/$1');
                $routes->add('/', 'MenusController::index');
            }
        );
        $routes->group(
            'users',
            static function (RouteCollection $routes) {
                $routes->add('index', 'UsersController::index');
                $routes->add('add', 'UsersController::add');
                $routes->add('edit/(:num)', 'UsersController::edit/$1');
                $routes->add('view/(:num)', 'UsersController::view/$1');
                $routes->add('delete/(:num)', 'UsersController::delete/$1');
                $routes->add('/', 'UsersController::index');
            }
        );
        $routes->group(
            'profile',
            static function (RouteCollection $routes) {
                $routes->get('index', 'ProfileController::edit');
                $routes->add('edit', 'ProfileController::edit');
                $routes->add('/', 'ProfileController::edit');
            }
        );
        $routes->group(
            'media',
            static function (RouteCollection $routes) {
                $routes->add('index', 'MediaController::index');
                $routes->post('upload', 'MediaController::upload');
                $routes->post('remove-file', 'MediaController::removeFile');
                $routes->post('remove-dir', 'MediaController::removeDir');
                $routes->post('create-folder', 'MediaController::createFolder');
                $routes->get('ckbrowse', 'MediaController::ckbrowse');
                $routes->post('ckupload', 'MediaController::ckupload');
                $routes->get('jo-browse', 'MediaController::joditBrowse');
                $routes->post('jo-upload', 'MediaController::joditUpload');
                $routes->add('/', 'MediaController::index');
            }
        );
        $routes->group(
            'settings',
            static function (RouteCollection $routes) {
                $routes->get('index', 'SettingsController::index');
                $routes->post('save/(:num)', 'SettingsController::save/$1');
                $routes->post('add', 'SettingsController::add');
                $routes->post('delete/(:num)', 'SettingsController::delete/$1');
                $routes->get('disable-tour', 'SettingsController::disableTour');
                $routes->get('/', 'SettingsController::index');
            }
        );
        $routes->group(
            'system',
            static function (RouteCollection  $routes) {
                $routes->get('index', 'SystemController::index');
                $routes->post('update', 'SystemController::update');
                $routes->post('clearcache', 'SystemController::clearCache');
                $routes->post('clearlogs', 'SystemController::clearLogs');
                $routes->post('migrate', 'SystemController::migrate');
                $routes->get('/', 'SystemController::index');
            }
        );
    }
);
