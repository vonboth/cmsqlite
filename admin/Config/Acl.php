<?php


namespace Admin\Config;


use CodeIgniter\Config\BaseConfig;

class Acl extends BaseConfig
{
    protected $admin = [
        'allow' => ['*'],
        'deny' => []
    ];

    protected $manager = [
        'allow' => [],
        'deny' => []
    ];

    /** @var array $guest allow / deny resources for guest */
    protected $guest = [
        'allow' => [
            '/admin/authenticate/login',
            'admin/authenticate/logout'
        ],
        'deny' => []
    ];

    /**
     * get
     * @param $prop
     * @return mixed|null
     */
    public function __get($prop)
    {
        if ($this->$prop) {
            return $this->$prop;
        } else {
            return null;
        }
    }
}