<?php

namespace Admin\System;

use CodeIgniter\Database\BaseConnection;

abstract class Updates
{
    /**
     * @var string $version
     */
    protected $version;

    /**
     * @var BaseConnection $db
     */
    protected $db;

    /**
     * run the update
     * @return void
     */
    abstract public function up();

    /**
     * @param $db
     * @return Updates
     */
    public function setDb($db): Updates
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
