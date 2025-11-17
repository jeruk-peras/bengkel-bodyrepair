<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_karyawan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'no_ktp' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tanggal_lahir' => [
                'type'       => 'date',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-Laki', 'Perempuan'],
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'jabatan' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin', 'Group Head', 'Mekanik'],
            ],
            'dapartemen' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tanggal_mulai_kerja' => [
                'type'       => 'DATE',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cabang_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_karyawan', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('karyawan', true);
    }
}
