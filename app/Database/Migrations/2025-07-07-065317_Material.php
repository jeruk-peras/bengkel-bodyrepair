<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Material extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_material' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_material' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'merek' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'harga' => [
                'type'       => 'DOUBLE',
            ],
            'stok' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'satuan_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'jenis_id' => [
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
        $this->forge->addKey('id_material', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('satuan_id', 'satuan', 'id_satuan', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('jenis_id', 'jenis', 'id_jenis', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('material');
    }

    public function down()
    {
        $this->forge->dropTable('material', true);
    }
}
