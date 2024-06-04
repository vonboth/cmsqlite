<?php

namespace Admin\Config;

use Admin\Services\MenuService;
use CodeIgniter\Config\BaseService;

/**
 * Admin Services Configuration file.
 */
class Services extends BaseService
{
    /**
     *
     * @param $getShared
     * @return object
     */
    public static function menu($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('menu');
        }

        return new MenuService();
    }
}
