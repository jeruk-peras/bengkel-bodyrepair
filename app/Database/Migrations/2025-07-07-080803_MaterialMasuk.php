<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MaterialMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_material_masuk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type'       => 'datetime',
            ],
            'no_delivery' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'suplier' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'total_harga' => [
                'type'       => 'DOUBLE',
            ],
            'catatan' => [
                'type'       => 'TEXT',
            ],
            'status' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'cabang_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_material_masuk', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('material_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('material_masuk', true);
    }
}
