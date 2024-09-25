<?php

namespace Config;

use Admin\Filters\AuthenticateFilter;
use Admin\Filters\AuthorizeFilter;
use Admin\Filters\LoginThrottleFilter;
use App\Filters\MaintenanceFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

/**
 * Class Filters
 * @package Config
 */
class Filters extends BaseFilters
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * CMSQLITE NEEDS THIS TO ENSURE INSTALLATION
         */
        // If Install-Dir exists, we want to have some Filters to ensure Installation
        if (is_dir(ROOTPATH . 'install')) {
            $this->aliases += ['install' => \Install\Filters\InstallationFilter::class];
            $this->filters += ['install' => ['before' => ['/', 'install', 'install/*']]];
        }
    }

    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'authenticate' => AuthenticateFilter::class,
        'authorize' => AuthorizeFilter::class,
        'loginThrottle' => LoginThrottleFilter::class,
        'maintenance' => MaintenanceFilter::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors' => Cors::class,
        'forcehttps' => ForceHTTPS::class,
        'pagecache' => PageCache::class,
        'performance' => PerformanceMetrics::class,
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];


    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot'
            'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot'
            // 'secureheaders'
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [
        'maintenance' => ['before' => ['*']],
        'loginThrottle' => ['before' => ['admin/authenticate/login']],
        'authenticate' => ['before' => ['admin', 'admin/*']],
        // TODO: AUTHORIZE FILTER IN ROUTES?
        //'authorize' => ['before' => ['*']]
    ];
}
