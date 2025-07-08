<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MaterialMasukDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_material_masuk_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'material_masuk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'material_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],            
            'harga_masuk' => [
                'type'       => 'DOUBLE',
            ],
            'stok_masuk' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);
        $this->forge->addKey('id_material_masuk_detail', true);
        $this->forge->addForeignKey('material_masuk_id', 'material_masuk', 'id_material_masuk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('material_id', 'material', 'id_material', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('material_masuk_detail');
    }

    public function down()
    {
        $this->forge->dropTable('material_masuk_detail', true);
    }
}
