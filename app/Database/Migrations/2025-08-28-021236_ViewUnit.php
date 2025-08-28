<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ViewUnit extends Migration
{
    public function up()
    {
        $this->db->query("CREATE VIEW all_unit_status AS SELECT u.*,
                CASE 
                    WHEN u.status = 0 
                    THEN COALESCE(
                            (SELECT ush.nama_status 
                            FROM unit_status us 
                            JOIN unit_status_harga ush ON ush.id_unit_status_harga = us.unit_status_harga_id 
                            WHERE ush.unit_id = u.id_unit 
                            ORDER BY us.tanggal_update DESC 
                            LIMIT 1
                            ), 'SEDANG PROSES' )
                    ELSE 'SELESAI'
                END AS nama_status
            FROM unit u");
    }

    public function down()
    {
        $this->db->query("DROP VIEW IF EXISTS all_unit_status");
    }
}
