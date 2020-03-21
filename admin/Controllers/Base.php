<?php

namespace Admin\Controllers;

use CodeIgniter\Controller;

class Base extends Controller
{
    public function index()
    {
        var_dump('Hello Admin');
        exit;
    }

}