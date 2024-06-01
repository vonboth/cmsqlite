<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity\Entity;

/**
 * Class Base
 * @package Admin\Models\Entities
 */
class Base extends Entity
{
    /** @var string $locale */
    protected $locale = '';

    /** @var bool $translationEnabled */
    protected $translationEnabeled = false;

    /**
     * @inheritdoc
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $this->translationEnabeled = config('Admin\Config\SystemSettings')->translations;
        $this->locale = service('language')->getLocale();
    }
}
