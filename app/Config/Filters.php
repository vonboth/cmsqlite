<?php

namespace Config;

use Admin\Filters\AuthenticateFilter;
use Admin\Filters\AuthorizeFilter;
use Admin\Filters\LoginThrottleFilter;
use App\Filters\MaintenanceFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

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

  /**
   * Configures aliases for Filter classes to
   * make reading things nicer and simpler.
   *
   * @var array
   */
  public $aliases = [
    'csrf' => CSRF::class,
    'toolbar' => DebugToolbar::class,
    'honeypot' => \CodeIgniter\Filters\Honeypot::class,
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
   *
   * @var array
   */
  public $globals = [
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
   * 'post' => ['csrf', 'throttle']
   *
   * @var array
   */
  public $methods = [];

  /**
   * List of filter aliases that should run on any
   * before or after URI patterns.
   *
   * Example:
   * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
   *
   * @var array
   */
  public $filters = [
    'maintenance' => ['before' => ['*']],
    'loginThrottle' => ['before' => ['admin/authenticate/login']],
    'authenticate' => ['before' => ['admin', 'admin/*']],
    // TODO: AUTHORIZE FILTER IN ROUTES?
    //'authorize' => ['before' => ['*']]
  ];
}
