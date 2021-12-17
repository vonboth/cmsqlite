<?php


namespace Admin\Config;


use Admin\Models\SettingsModel;
use CodeIgniter\Config\BaseConfig;

/**
 * Class System
 * Holds the system settings maintained in the
 * database by the admin of the system.
 * Typical settings are:
 * - language
 * - theme
 * ...
 *
 * Usage: $systemSettings->theme
 *
 * @package Admin\Config
 * @property string $theme
 * @property string $admin_theme
 * @property string $language
 */
class SystemSettings extends BaseConfig
{
    /** @var string $theme theme for the frontend */
    public string $theme = 'default';

    /** @var string $admin_theme theme for the admin section */
    public string $admin_theme = 'default';

    /** @var string $language default language */
    public string $language = 'de';

    /** @var int $maintenance page on maintenance mode */
    public int $maintenance = 0;

    /** @var bool $tour start backend tour  */
    public bool $tour = false;

    /** @var string $ckeditor the type of editor to be loaded from CDN: basic | standard | full */
    public string $editor_style = 'standard';

    /** @var string[] additional settings from the database */
    public static $registrars = [
        'Admin\Models\SettingsModel'
    ];

    /**
     * magic get property from settings
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
        return null;
    }

    /**
     * get setting from user settings in database
     * @param $key
     * @param $default
     * @return mixed|string|null
     */
    public function get($key, $default)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        } elseif ($default) {
            return $default;
        } else {
            return null;
        }
    }
}