<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Closing extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_closing' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type'       => 'datetime',
            ],
            'periode_closing' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'catatan' => [
                'type'           => 'TEXT',
            ],
            'status' => [
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
        $this->forge->addKey('id_closing', true);
        $this->forge->addUniqueKey(['periode_closing', 'cabang_id'], 'Unique Closing');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('closing');
    }

    public function down()
    {
        $this->forge->dropTable('closing', true);
    }
}
