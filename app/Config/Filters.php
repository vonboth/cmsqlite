<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Class Filters
 * @package Config
 */
class Filters extends BaseConfig
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        // If Install-Dir exists, we want to have some Filters to ensure Installation
        if (is_dir(ROOTPATH . 'install')) {
            $this->aliases += ['install' => \Install\Filters\InstallationFilter::class];
            $this->filters += ['install' => ['before' => ['/', 'install', 'install/*']]];
        }
    }

    // Makes reading things below nicer,
    // and simpler to change out script that's used.
    public $aliases = [
        'csrf' => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'authenticate' => \Admin\Filters\AuthenticateFilter::class,
        'authorize' => \Admin\Filters\AuthorizeFilter::class,
        'loginThrottle' => \Admin\Filters\LoginThrottleFilter::class,
        'maintenance' => \App\Filters\MaintenanceFilter::class
    ];

    // Always applied before every request
    public $globals = [
        'before' => [
            //'honeypot'
            'csrf'
        ],
        'after' => [
            'toolbar',
            //'honeypot'
        ],
    ];

    // Works on all of a particular HTTP method
    // (GET, POST, etc) as BEFORE filters only
    //     like: 'post' => ['CSRF', 'throttle'],
    public $methods = [];

    // List filter aliases and any before/after uri patterns
    // that they should run on, like:
    //    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
    public $filters = [
        'maintenance' => ['before' => ['*']],
        'loginThrottle' => ['before' => ['admin/authenticate/login']],
        'authenticate' => ['before' => ['admin', 'admin/*']],
        // TODO: AUTHORIZE FILTER IN ROUTES?
        //'authorize' => ['before' => ['*']]
    ];
}
