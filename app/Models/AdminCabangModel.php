<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminCabangModel extends Model
{
    protected $table            = 'admin_cabang';
    protected $primaryKey       = 'id_admin';
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
        'id_admin'     => 'string', 
        'nama_lengkap' => 'required|max_length[300]',
        'no_handphone' => 'required|max_length[20]',
        'alamat'       => 'required',
        'username'     => 'required|max_length[100]|is_unique[admin_cabang.username,id_admin,{id_admin}]|is_unique[users.username]',
        'status'       => 'required|integer',
        'by'           => 'required|integer',
        'cabang_id'    => 'required|integer',
    ];
    protected $validationMessages   = [
        'nama_lengkap' => [
            'required'   => 'Nama lengkap wajib diisi.',
            'max_length' => 'Nama lengkap maksimal 300 karakter.',
        ],
        'no_handphone' => [
            'required'   => 'No handphone wajib diisi.',
            'max_length' => 'No handphone maksimal 20 karakter.',
        ],
        'alamat' => [
            'required'   => 'Alamat wajib diisi.',
        ],
        'username' => [
            'required'   => 'Username wajib diisi.',
            'max_length' => 'Username maksimal 100 karakter.',
            'is_unique'  => 'Username sudah digunakan.',
        ],
        'status' => [
            'required' => 'Status wajib diisi.',
            'integer'  => 'Status harus berupa angka.',
        ],
        'by' => [
            'required' => 'By wajib diisi.',
            'integer'  => 'By harus berupa angka.',
        ],
        'cabang_id' => [
            'required' => 'Cabang wajib diisi.',
            'integer'  => 'Cabang harus berupa angka.',
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
