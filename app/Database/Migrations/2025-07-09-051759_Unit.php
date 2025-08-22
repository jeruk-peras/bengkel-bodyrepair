<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Unit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unit' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'nomor_spp' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_sa' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],

            'nomor_polisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'model_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'warna_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'asuransi_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'nomor_mesin' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nomor_rangka' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],

            'tanggal_masuk' => [
                'type'       => 'DATE',
            ],
            'estimasi_selesai' => [
                'type'       => 'DATE',
            ],
            'detail_pengerjaan' => [
                'type'       => 'TEXT',
            ],

            'harga_spp' => [
                'type'       => 'DOUBLE',
            ],
            'diskon' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'jumlah_diskon' => [
                'type'       => 'DOUBLE',
            ],
            'harga_panel' => [
                'type'       => 'DOUBLE',
            ],
            'jumlah_panel' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'upah_mekanik' => [
                'type'       => 'DOUBLE',
            ],
            'total_upah_mekanik' => [
                'type'       => 'DOUBLE',
            ],

            'status' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'color' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'cabang_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_unit', true);
        $this->forge->addForeignKey('cabang_id', 'cabang', 'id_cabang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('unit');
    }

    public function down()
    {
        $this->forge->dropTable('unit', true);
    }
}
