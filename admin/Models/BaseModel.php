<?php


namespace Admin\Models;


use CodeIgniter\Model;

/**
 * Class BaseModel
 * @package Admin\Models
 * TODO: IMPL. hasOne, hasMany, belongsTo VIA MAGIC GET IN ENEITY AND PULIC FUNCTIONS IN BASE MODEL, SEE LARAVEL OR
 * https://stackoverflow.com/questions/37582848/what-is-the-difference-between-belongsto-and-hasone-in-laravel
 * TODO: EVTL. HASONE... IN ENTITY?
 */
class BaseModel extends Model
{
    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    protected $relations = [];

    /**
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
            switch($setting['type']) {
                case 'belongsTo':
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