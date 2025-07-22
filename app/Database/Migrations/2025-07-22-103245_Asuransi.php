<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Asuransi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_asuransi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_asuransi' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_asuransi', true);
        $this->forge->createTable('asuransi');
    }

    public function down()
    {
        $this->forge->dropTable('asuransi', true);
    }
}
