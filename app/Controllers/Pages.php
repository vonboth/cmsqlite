<?php

namespace App\Controllers;

/**
 * Class Home
 * @package App\Controllers
 */
class Pages extends Base
{
    /**
     * Entrypoint for the startpage
     */
    public function start()
    {
        return view(
            'Themes\default\home',
            []
        );
    }

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
