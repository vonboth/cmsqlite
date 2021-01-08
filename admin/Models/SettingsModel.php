<?php


namespace Admin\Models;

use Config\Services;

/**
 * Class SettingsModel
 * @package Admin\Models
 */
class SettingsModel extends BaseModel
{
    protected $table = 'settings';
    protected $returnType = 'Admin\Models\Entities\Setting';
    protected $allowedFields = ['name', 'value'];

    public static function SystemSettings()
    {
        $db = db_connect();
        $settings = $db->query('SELECT `name`, `value` FROM settings')->getResult();
        $return = [];
        foreach ($settings as $setting) {
            $return[$setting->name] = $setting->value;
        }
        return $return;
    }
}