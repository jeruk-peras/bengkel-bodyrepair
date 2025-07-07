<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_lengkap' => 'XXXXXXXXX',
            'no_handphone' => '0123456789',
            'alamat'       => 'XXXXXXXXX',
            'username'     => 'admin',
            'password'     => password_hash('#Admin01', PASSWORD_DEFAULT),
            'role'         => 'Super Admin',
            'by'           => 1,
            'status'       => 1,
        ];

        $this->db->table('users')->insert($data);
    }
}
