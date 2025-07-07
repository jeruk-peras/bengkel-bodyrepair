<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdminCabang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_admin' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'defalut'    => 1
            ],
            'by' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'cabang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_admin', true);
        $this->forge->addForeignKey('by', 'users', 'id_user', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('admin_cabang');
    }

    public function down()
    {
        $this->forge->dropTable('admin_cabang', true);
    }
}
