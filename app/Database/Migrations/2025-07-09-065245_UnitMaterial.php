<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitMaterial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unit_material' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'material_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'tanggal' => [
                'type'           => 'DATETIME',
            ],
            'harga' => [
                'type'           => 'DOUBLE',
            ],
            'jumlah' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'detail_jumlah' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],

            'mekanik_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'unit_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);
        $this->forge->addKey('id_unit_material', true);
        $this->forge->addForeignKey('unit_id', 'unit', 'id_unit', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mekanik_id', 'mekanik', 'id_mekanik', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('material_id', 'material', 'id_material', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('unit_material');
    }

    public function down()
    {
        $this->forge->dropTable('unit_material', true);
    }
}
