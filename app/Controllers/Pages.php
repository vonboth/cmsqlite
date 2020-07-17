<?php

namespace App\Controllers;

/**
 * Class Home
 * @package App\Controllers
 */
class Pages extends Base
{
    public function index($name = null)
    {
        return view(
            'Themes\default\home',
            [
                'description' => 'Hallo',
                'author' => 'Hallo',
                'title' => 'Hallo Title',
            ]
        );
    }
}
