<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitStatusHarga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unit_status_harga' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_status' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'harga_status' => [
                'type'       => 'DOUBLE',
            ],
            'unit_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);
        $this->forge->addKey('id_unit_status_harga', true);
        $this->forge->addForeignKey('unit_id', 'unit', 'id_unit', 'CASCADE', 'CASCADE');
        $this->forge->createTable('unit_status_harga');
    }

    public function down()
    {
        $this->forge->dropTable('unit_status_harga', true);
    }
}
