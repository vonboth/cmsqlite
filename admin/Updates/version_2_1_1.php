<?php

namespace Admin\Updates;

use Admin\System\Updates;

/**
 * Update to version 2.1.1
 */
return new class extends Updates {

    /** @inheritdoc */
    protected $version = '2.1.1';

    /** @inheritdoc */
    public function up()
    {
        $row = $this->db->table('settings')
            ->where('name', 'supportedLayouts')
            ->get()
            ->getRow();

        if (!$row) {
            $this->db->table('settings')
                ->insert([
                    'name' => 'supportedLayouts',
                    'value' => 'start, page',
                    'created' => date('Y-m-d H:i:s'),
                    'updated' => date('Y-m-d H:i:s'),
                ]);
        }


        $row = $this->db->table('settings')
            ->where('name', 'supportedTranslations')
            ->get()
            ->getRow();

        if (!$row) {
            $this->db->table('settings')
                ->insert([
                    'name' => 'supportedTranslations',
                    'value' => 'de, en',
                    'created' => date('Y-m-d H:i:s'),
                    'updated' => date('Y-m-d H:i:s'),
                ]);
        }
    }
};
