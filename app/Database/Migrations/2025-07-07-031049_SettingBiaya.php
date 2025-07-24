<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SettingBiaya extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_setting_biaya' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'diskon' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'harga_panel' => [
                'type'       => 'DOUBLE',
            ],
            'upah_mekanik' => [
                'type'       => 'DOUBLE',
            ],
            'sharing' => [
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
        $this->forge->addKey('id_setting_biaya', true);
        $this->forge->addUniqueKey('cabang_id');
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('setting_biaya');
    }

    public function down()
    {
        $this->forge->dropTable('setting_biaya', true);
    }
}
