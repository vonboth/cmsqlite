<?php


namespace Admin\Models;


use CodeIgniter\Model;
use Tatter\Relations\Traits\ModelTrait;

/**
 * Class BaseModel
 * @package Admin\Models
 */
class BaseModel extends Model
{
    use ModelTrait;

    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    /**
     * find one item from the database
     * @param $id
     * @return array|object|null
     */
    public function one($id)
    {
        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }
}