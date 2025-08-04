<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClosingDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_closing_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'closing_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'unit_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
        ]);
        $this->forge->addKey('id_closing_detail', true);
        $this->forge->addForeignKey('closing_id', 'closing', 'id_closing', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('unit_id', 'unit', 'id_unit', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('closing_detail');
    }

    public function down()
    {
        $this->forge->dropTable('closing_detail', true);
    }
}
