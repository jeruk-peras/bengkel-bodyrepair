<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KomponenGaji extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_komponen_gaji' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_komponen_gaji' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'jenis' => [
                'type'       => 'ENUM',
                'constraint' => ['Potongan', 'Pendapatan'],
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_komponen_gaji', true);
        $this->forge->createTable('komponen_gaji');
    }

    public function down()
    {
        $this->forge->dropTable('komponen_gaji', true);
    }
}
