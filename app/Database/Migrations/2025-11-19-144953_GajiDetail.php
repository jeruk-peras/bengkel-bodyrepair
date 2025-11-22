<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GajiDetail extends Migration
{
   public function up()
    {
        $this->forge->addField([
            'id_gaji_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'gaji_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'karyawan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'komponen_gaji_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nilai' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_gaji_detail', true);
        $this->forge->addForeignKey('gaji_id', 'gaji', 'id_gaji', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('karyawan_id', 'karyawan', 'id_karyawan', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('komponen_gaji_id', 'komponen_gaji', 'id_komponen_gaji', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('gaji_detail');
    }

    public function down()
    {
        $this->forge->dropTable('gaji_detail', true);
    }
}
