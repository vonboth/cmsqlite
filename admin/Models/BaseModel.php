<?php


namespace Admin\Models;


use CodeIgniter\Model;

/**
 * Class BaseModel
 * @package Admin\Models
 */
class BaseModel extends Model
{
    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';
}