<?php


namespace App\Models;


use CodeIgniter\Model;

class BaseModel extends Model
{
    public function one($id)
    {
        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }
}