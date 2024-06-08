<?php

namespace Admin\Updates;

use Admin\System\Updates;

return new class extends Updates {
    /**
     * @var string $version
     */
    protected $version = '2.1.0';

    /**
     * run the update
     * @return void
     */
    public function up()
    {
        $row = $this->db->table('settings')->where('name', 'translations')->get()->getRow();
        if (!$row) {
            $this->db->table('settings')->insert([
                'name' => 'translations',
                'value' => '0',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ]);
        }
    }
};
