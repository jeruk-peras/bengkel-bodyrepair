<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gaji extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_gaji' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type'       => 'date',
            ],
            'periode' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default'    => '0',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_gaji', true);
        $this->forge->createTable('gaji');
    }

    public function down()
    {
        $this->forge->dropTable('gaji', true);
    }
}
