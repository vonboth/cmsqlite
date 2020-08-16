<?php


namespace Admin\Controllers;


/**
 * Class Index
 * @package Admin\Controllers
 */
class Start extends Base
{
    protected $controllerName = 'Start';

    public function index()
    {
        return view('Admin\Views\Start\start.php');
    }
}