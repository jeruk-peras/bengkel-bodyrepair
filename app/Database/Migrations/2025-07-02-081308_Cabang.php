<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cabang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_cabang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_cabang' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'lokasi_cabang' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'alamat_lengkap' => [
                'type'       => 'TEXT',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_cabang', true);
        $this->forge->createTable('cabang');
    }

    public function down()
    {
        $this->forge->dropTable('cabang', true);
    }
}
