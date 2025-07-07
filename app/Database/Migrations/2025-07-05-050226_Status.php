<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Status extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_status' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'harga_status' => [
                'type'       => 'DOUBLE',
            ],
            'cabang_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_status', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('status');
    }

    public function down()
    {
        $this->forge->dropTable('status', true);
    }
}
