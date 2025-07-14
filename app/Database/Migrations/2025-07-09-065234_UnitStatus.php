<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unit_status' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'tanggal_update' => [
                'type'       => 'DATETIME',
            ],
            'unit_status_harga_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'catatan' => [
                'type'           => 'TEXT',
            ],
            'gambar_status' => [
                'type'       => 'VARCHAR',
                'constraint'     => '100',
            ],
            'unit_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);
        $this->forge->addKey('id_unit_status', true);
        $this->forge->addForeignKey('unit_id', 'unit', 'id_unit', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('unit_status_harga_id', 'unit_status_harga', 'id_unit_status_harga', 'CASCADE', 'CASCADE');
        $this->forge->createTable('unit_status');
    }

    public function down()
    {
        $this->forge->dropTable('unit_status', true);
    }
}
