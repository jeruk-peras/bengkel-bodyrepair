<?php

namespace App\Models;

use CodeIgniter\Model;

class KomponenGajiModel extends Model
{
    protected $table            = 'komponen_gaji';
    protected $primaryKey       = 'id_komponen_gaji';
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
    protected $validationRules = [
        'nama_komponen_gaji' => 'required|trim|max_length[500]',
        'jenis'               => 'required|in_list[Potongan,Pendapatan]',
    ];

    protected $validationMessages = [
        'nama_komponen_gaji' => [
            'required'   => 'Nama komponen gaji harus diisi.',
            'max_length' => 'Nama komponen gaji maksimal 500 karakter.',
        ],
        'jenis' => [
            'required' => 'Jenis harus dipilih.',
            'in_list'  => 'Jenis harus salah satu dari: Potongan atau Pendapatan.',
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
