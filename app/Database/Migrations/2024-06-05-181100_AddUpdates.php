<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdates extends Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        if (!$this->db->tableExists('updates')) {
            $fields = [
                'version' => [
                    'type' => 'TEXT'
                ],
                'success' => [
                    'type' => 'INTEGER',
                    'constraint' => 1,
                    'null' => true,
                ],
                'created' => [
                    'type' => 'DATETIME',
                    'default' => 'CURRENT_TIMESTAMP',
                    'null' => true,
                ]
            ];
            $this->forge->addField('id');
            $this->forge->addField($fields);
            $this->forge->createTable('updates');
        }
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        if ($this->db->tableExists('updates')) {
            $this->forge->dropTable('updates');
        }
    }
}
