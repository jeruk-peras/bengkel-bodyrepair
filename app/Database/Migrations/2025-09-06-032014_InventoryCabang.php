<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryCabang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_inventory_cabang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'inventory_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'jumlah' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'rusak' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'catatan' => [
                'type'       => 'TEXT',
            ],
            'gambar_kondisi' => [
                'type'       => 'VARCHAR',
                'constraint' => 400,
            ],
            'cabang_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_inventory_cabang', true);
        $this->forge->addForeignKey('inventory_id', 'inventory', 'id_inventory', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('inventory_cabang');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_cabang', true);
    }
}
