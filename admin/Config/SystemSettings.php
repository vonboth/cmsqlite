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
 * - layout
 * ...
 *
 * Usage: $systemSettings->get(KEY, DEFAULT);
 * of: $systemSettings->layout
 *
 * @package Admin\Config
 */
class SystemSettings extends BaseConfig
{
    /** @var array|string[] $defaults default settings */
    protected array $defaults = [
        'layout' => 'default',
        'adminLayout' => 'default',
        'language' => 'de'
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
     */
    private function _setSettings()
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
}