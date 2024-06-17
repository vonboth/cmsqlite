<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuitemsRmLayout extends Migration
{
    /**
     * migrate up
     * @return void
     */
    public function up()
    {
        if ($this->db->fieldExists('layout', 'menuitems')) {
            $this->forge->dropColumn('menuitems', 'layout');
        }
    }

    /**
     * migrate down
     * @return void
     */
    public function down()
    {
        if (!$this->db->fieldExists('layout', 'menuitems')) {
            $this->forge->addColumn('menuitems', [
                'layout' => [
                    'type' => 'VARCHAR',
                    'null' => true,
                ],
            ]);
        }
    }
}
