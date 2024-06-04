<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for adding menu translations table
 */
class AddMenuTranslations extends Migration
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        if (!$this->db->tableExists('menu_translations')) {
            $fields = [
                'menuitem_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                ],
                'language' => [
                    'type' => 'TEXT',
                ],
                'title' => [
                    'type' => 'TEXT',
                ],
                'created' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ]
            ];

            $this->forge->addField('id');
            $this->forge->addField($fields);
            $this->forge->addForeignKey('menuitem_id', 'menuitems', 'id', '', 'CASCADE');
            $this->forge->createTable('menu_translations');
        }
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        if ($this->db->tableExists('menu_translations')) {
            $this->forge->dropTable('menu_translations');
        }
    }
}
