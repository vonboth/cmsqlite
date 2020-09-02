<?php


namespace Admin\Config;


use CodeIgniter\Config\BaseConfig;

class Acl extends BaseConfig
{
    protected $admin = [
        'allow' => [],
        'deny' => []
    ];

    protected $manager = [
        'allow' => [],
        'deny' => [
            '/admin/users'
        ]
    ];

    protected $guest = [
        'allow' => [],
        'deny' => []
    ];

    protected $public = [
        'allow' => [],
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