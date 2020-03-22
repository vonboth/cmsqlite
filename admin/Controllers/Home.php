<?php


namespace Admin\Controllers;


/**
 * Class Index
 * @package Admin\Controllers
 */
class Home extends Base
{
    public function index()
    {
        return view('AdminThemes\default\home.php');
    }
}