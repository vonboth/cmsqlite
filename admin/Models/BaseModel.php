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

    protected $relations = [];

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

    /**
     * Maybe later as array
     * @param string $relation
     * @param int $limit
     * @param int $offset
     * @return array
     * @deprecated
     */
    public function findAllWith($relation, int $limit = 0, int $offset = 0)
    {
        $modelName = strtolower($relation);
        if (!array_key_exists($modelName, $this->relations)) {
            return $this->findAll($limit, $offset);
        }

        $setting = $this->relations[$modelName];

        $modelClass = '\\Admin\\Models\\' . ucfirst($modelName) . 'Model';
        $instance = new $modelClass();

        $currents = $this->findAll($limit, $offset);

        foreach ($currents as &$current) {
            switch ($setting['type']) {
                case 'hasOne':
                    //case 'belongsTo':
                    $varName = singular($relation);
                    $res = $instance
                        ->where('id', $current->{$setting['key']})
                        ->first();
                    $current->$varName = (is_null($res)) ? null : $res;
                    break;

                case 'hasMany':
                    $res = $instance
                        ->where($setting['key'], $current->id)
                        ->get()
                        ->getResult();
                    $current->$modelName = (is_null($res)) ? null : $res;
                    break;
            }
        }

        return $currents;
    }
}