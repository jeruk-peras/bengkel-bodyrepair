<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kasbon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kasbon' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'karyawan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => '0',
            ],
            'tanggal' => [
                'type'       => 'date',
            ],
            'alasan' => [
                'type'       => 'text',
            ],
            'jumlah' => [
                'type'       => 'double',
            ],
            'disetujui' => [
                'type'       => 'double',
            ],
            'jenis' => [
                'type'       => 'enum',
                'constraint' => ['pinjam', 'bayar'],
            ],
            'status' => [
                'type'       => 'enum',
                'constraint' => ['pengajuan', 'terima', 'tolak'],
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_kasbon', true);
        $this->forge->addForeignKey('karyawan_id','karyawan', 'id_karyawan', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('kasbon');
    }

    public function down()
    {
        $this->forge->dropTable('kasbon', true);
    }
}
