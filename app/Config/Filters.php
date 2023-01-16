<?php

namespace Config;

use Admin\Filters\AuthenticateFilter;
use Admin\Filters\AuthorizeFilter;
use Admin\Filters\LoginThrottleFilter;
use App\Filters\MaintenanceFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

/**
 * Class Filters
 * @package Config
 */
class Filters extends BaseConfig
{
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
      'toolbar',
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
  public $filters = [
    'maintenance' => ['before' => ['*']],
    'loginThrottle' => ['before' => ['admin/authenticate/login']],
    'authenticate' => ['before' => ['admin', 'admin/*']],
    // TODO: AUTHORIZE FILTER IN ROUTES?
    //'authorize' => ['before' => ['*']]
  ];
}
