<?php

namespace App\Models;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table            = 'cabang';
    protected $primaryKey       = 'id_cabang';
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
        'nama_cabang'     => 'required|string|max_length[200]',
        'lokasi_cabang'   => 'required|string|max_length[200]',
        'alamat_lengkap'  => 'required|string',
        'data_gudang'     => 'permit_empty|numeric',
    ];
    protected $validationMessages   = [
        'nama_cabang' => [
            'required'   => 'Nama cabang wajib diisi.',
            'max_length' => 'Nama cabang maksimal 200 karakter.',
        ],
        'lokasi_cabang' => [
            'required'   => 'Lokasi cabang wajib diisi.',
            'max_length' => 'Lokasi cabang maksimal 200 karakter.',
        ],
        'alamat_lengkap' => [
            'required' => 'Alamat lengkap wajib diisi.',
        ],
        'data_gudang' => [
            'integer' => 'Jenis harus berupa angka bulat.',
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
