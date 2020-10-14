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
}