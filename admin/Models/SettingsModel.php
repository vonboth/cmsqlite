<?php


namespace Admin\Models;

/**
 * Class SettingsModel
 * @package Admin\Models
 * TODO: LOAD DB-SETTINGS INTO A REGULAR CONFIGURATION FILE TO ALLOW SIMPLE ACCESS!
 */
class SettingsModel extends BaseModel
{
    protected $table = 'settings';
    protected $returnType = 'Admin\Models\Entities\Setting';
    protected $allowedFields = ['name', 'value'];
}