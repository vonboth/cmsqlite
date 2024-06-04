<?php


namespace Admin\Models;


use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;
use Tatter\Relations\Traits\ModelTrait;

/**
 * Class BaseModel
 * @package Admin\Models
 */
class BaseModel extends Model
{
    use ModelTrait;

    /** @inheritdoc */
    protected $useTimestamps = true;

    /** @inheritdoc */
    protected $updatedField = 'updated';

    /** @inheritdoc */
    protected $createdField = 'created';

    /**
     * Flag if translations are enabled in the DB
     * @var bool $translationEnabeld
     */
    protected $translationEnabeld = false;

    /** @inheritdoc */
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        // enable foreign keys
        // $this->db->simpleQuery('PRAGMA foreign_keys = ON;');

        $this->translationEnabeld = (bool)config('Admin\Config\SystemSettings')->translations;
    }

    /**
     * find one item from the database
     * @param $id
     * @return array|null
     */
    public function one($id): ?array
    {
        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }
}
