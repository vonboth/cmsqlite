<?php


namespace Admin\Models;

/**
 * Class SettingsModel
 * @package Admin\Models
 */
class SettingsModel extends BaseModel
{
    protected $table = 'settings';
    protected $returnType = 'Admin\Models\Entities\Setting';
    protected $allowedFields = ['name', 'value'];

    /**
     * Read from the system settings from the database
     * @return array
     */
    public static function SystemSettings(): array
    {
        $db = db_connect();
        $settings = $db->query('SELECT `name`, `value` FROM settings')->getResult();
        $return = [];
        foreach ($settings as $setting) {
            if (strpos($setting->value, ',') !== false) {
                $setting->value = array_map('trim', explode(',', $setting->value));
            }
            $return[$setting->name] = $setting->value;
        }
        return $return;
    }


}
