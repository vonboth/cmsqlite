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
 * Usage: $systemSettings->get(KEY, DEFAULT);
 * of: $systemSettings->theme
 *
 * @package Admin\Config
 * @property string $theme
 * @property string $admin_theme
 * @property string $language
 */
class SystemSettings extends BaseConfig
{
    /** @var array|string[] $defaults default settings */
    protected array $defaults = [
        'theme' => 'default',
        'admin_theme' => 'default',
        'language' => 'de',
        'maintenance' => 0
    ];

    /** @var array|string[] $settings complete settings */
    protected array $settings = [];

    /**
     * System constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_setSettings();
    }

    /**
     * set the settings configured
     * in the databse
     *
     * @return void
     */
    private function _setSettings(): void
    {
        $this->settings = $this->defaults;
        $settings = new SettingsModel();
        $rows = $settings->findAll();
        foreach ($rows as $row) {
            $this->settings[$row->name] = $row->value;
        }
    }

    /**
     * magic get property from settings
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
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
        if (array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
        } elseif ($default) {
            return $default;
        } else {
            return null;
        }
    }

    /**
     * read a value from the database
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public static function read($key, $default)
    {
        $settings = new SettingsModel();
        $value = $settings->where('name', $key)->first()->get();
        return ($value) ? $value : $default;
    }
}