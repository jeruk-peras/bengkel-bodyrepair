<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_user'          => 'string',
        'nama_lengkap'     => 'required|max_length[300]',
        'no_handphone'     => 'required|max_length[20]',
        'alamat'           => 'required',
        'username'         => 'required|max_length[100]|is_unique[users.username,id_user,{id_user}]',
        'role'             => 'required|in_list[Super Admin,Admin,Admin Cabang, Finance]',
    ];
    protected $validationMessages   = [
        'nama_lengkap' => [
            'required'   => 'Nama Lengkap wajib diisi.',
            'max_length' => 'Nama Lengkap maksimal 300 karakter.',
        ],
        'no_handphone' => [
            'required'   => 'No Handphone wajib diisi.',
            'max_length' => 'No Handphone maksimal 20 karakter.',
        ],
        'alamat' => [
            'required'   => 'Alamat wajib diisi.',
        ],
        'username' => [
            'required'   => 'Username wajib diisi.',
            'max_length' => 'Username maksimal 100 karakter.',
            'is_unique'  => 'Username sudah digunakan.',
        ],
        'role' => [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role harus salah satu dari: Super Admin, Admin, Admin Cabang.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
