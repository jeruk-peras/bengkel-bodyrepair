<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CetakGambar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_cetak_gambar' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'cetak_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id_cetak_gambar', true);
        $this->forge->addForeignKey('cetak_id', 'cetak', 'id_cetak', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cetak_gambar');
    }

    public function down()
    {
        $this->forge->dropTable('cetak_gambar', true);
    }
}
