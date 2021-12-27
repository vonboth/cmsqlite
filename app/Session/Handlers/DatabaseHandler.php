<?php

namespace App\Session\Handlers;

class DatabaseHandler extends \CodeIgniter\Session\Handlers\DatabaseHandler
{
    /**
     * @inheritdoc
     */
    public function write($id, $data): bool
    {
        if ($this->lock === false) {
            return $this->fail();
        }

        if ($this->sessionID !== $id) {
            $this->rowExists = false;
            $this->sessionID = $id;
        }

        if ($this->rowExists === false) {
            $insertData = [
                'id'         => $id,
                'ip_address' => $this->ipAddress,
                'data'       => $this->platform === 'postgre' ? '\x' . bin2hex($data) : $data,
            ];

            if (! $this->db->table($this->table)->set('timestamp', 'datetime(\'now\')', false)->insert($insertData)) {
                return $this->fail();
            }

            $this->fingerprint = md5($data);
            $this->rowExists   = true;

            return true;
        }

        $builder = $this->db->table($this->table)->where('id', $id);

        if ($this->matchIP) {
            $builder = $builder->where('ip_address', $this->ipAddress);
        }

        $updateData = [];

        if ($this->fingerprint !== md5($data)) {
            $updateData['data'] = ($this->platform === 'postgre') ? '\x' . bin2hex($data) : $data;
        }

        if (! $builder->set('timestamp', 'datetime(\'now\')', false)->update($updateData)) {
            return $this->fail();
        }

        $this->fingerprint = md5($data);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function gc($max_lifetime)
    {
        return $this->db
          ->table($this->table)
          ->where('timestamp <', "datetime('now', '-$max_lifetime second')", false)
          ->delete() ? 1 : $this->fail();
    }
}
