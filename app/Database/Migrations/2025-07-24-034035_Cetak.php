<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cetak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_cetak' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kategori_cetak' => [
                'type'       => 'ENUM',
                'constraint' => ['epoxy', 'gandeng'],
            ],
            'unit_id' => [
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
        $this->forge->addKey('id_cetak', true);
        $this->forge->addForeignKey('unit_id', 'unit', 'id_unit', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('cetak');
    }

    public function down()
    {
        $this->forge->dropTable('cetak', true);
    }
}
