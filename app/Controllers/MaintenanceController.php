<?php


namespace App\Controllers;

/**
 * Class Maintenance
 * @package App\Controllers
 */
class MaintenanceController extends BaseController
{
    /**
     * index page
     * @return string
     */
    public function index()
    {
        return view("Themes\\$this->theme\\maintenance");
    }
}