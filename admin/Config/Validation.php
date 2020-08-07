<?php


namespace Admin\Config;


class Validation extends \Config\Validation
{
    public $templates = [
        'list' => 'Admin\Validation\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];
}