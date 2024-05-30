<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTranslations extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('translations')) {
            $fields = [
                'article_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                ],
                'language' => [
                    'type' => 'TEXT',
                ],
                'title' => [
                    'type' => 'TEXT',
                ],
                'alias' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'doc_key' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'content' => [
                    'type' => 'TEXT',
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => true,
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
            $this->forge->addForeignKey('article_id', 'articles', 'id', '', 'CASCADE');
            $this->forge->addForeignKey('user_id', 'users', 'id');
            $this->forge->createTable('translations');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('translations')) {
            $this->forge->dropTable('translations');
        }
    }
}
