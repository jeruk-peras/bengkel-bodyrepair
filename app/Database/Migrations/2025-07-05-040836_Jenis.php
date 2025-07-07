<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jenis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenis' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_jenis', true);
        $this->forge->createTable('jenis');
    }

    public function down()
    {
        $this->forge->dropTable('mekanik', true);
    }
}
