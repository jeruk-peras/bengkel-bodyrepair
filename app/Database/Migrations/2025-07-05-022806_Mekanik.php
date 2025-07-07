<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mekanik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mekanik' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_mekanik' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'cabang_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_mekanik', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('mekanik');
    }

    public function down()
    {
        $this->forge->dropTable('mekanik', true);
    }
}
