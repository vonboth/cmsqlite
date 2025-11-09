<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Admin\Validator\ArticleRules;
use Admin\Validator\AuthenticationRules;
use Admin\Validator\CategoryRules;
use Admin\Validator\MenuitemRules;
use Admin\Validator\MenuRules;
use Admin\Validator\UserRules;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
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
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
