<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table            = 'status';
    protected $primaryKey       = 'id_status';
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
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_status' => 'required|max_length[100]',
        'harga_status' => 'required|numeric',
        'cabang_id' => 'required|numeric',
    ];
    protected $validationMessages   = [
        'nama_status' => [
            'required' => 'Nama status wajib diisi.',
            'max_length' => 'Nama status maksimal 100 karakter.',
        ],
        'harga_status' => [
            'required' => 'Harga status wajib diisi.',
            'numeric' => 'Harga status harus berupa angka.',
        ],
        'cabang_id' => [
            'required' => 'Cabang wajib diisi.',
            'numeric' => 'Cabang harus berupa angka.',
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
