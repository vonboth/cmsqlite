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
     * @var \CodeIgniter\Database\BaseBuilder|\CodeIgniter\Database\ConnectionInterface|\CodeIgniter\Database\Query|mixed
     */
    protected $db;

    /**
     * @inheritdoc
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $this->translationEnabeled = config('Admin\Config\SystemSettings')->translations;
        $this->locale = service('language')->getLocale();

        $this->db = db_connect();
    }
}
