<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserAkses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_cabang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'cabang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
        ]);
        $this->forge->addKey('id_user_cabang', true);
        $this->forge->addForeignKey('user_id', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_cabang');
    }

    public function down()
    {
        $this->forge->dropTable('users_cabang', true);
    }
}
