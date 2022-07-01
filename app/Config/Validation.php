<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Admin\Validator\ArticleRules;
use Admin\Validator\AuthenticationRules;
use Admin\Validator\CategoryRules;
use Admin\Validator\MenuitemRules;
use Admin\Validator\MenuRules;
use Admin\Validator\UserRules;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        UserRules::class,
        ArticleRules::class,
        CategoryRules::class,
        MenuRules::class,
        MenuitemRules::class,
        AuthenticationRules::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
}
