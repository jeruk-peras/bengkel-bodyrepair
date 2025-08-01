<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table            = 'material';
    protected $primaryKey       = 'id_material';
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
        'nama_material' => [
            'label' => 'Nama Material',
            'rules' => 'required|max_length[200]',
        ],
        'merek' => [
            'label' => 'Merek',
            'rules' => 'required|max_length[100]',
        ],
        'harga' => [
            'label' => 'Harga',
            'rules' => 'required|numeric',
        ],
        'stok' => [
            'label' => 'Stok',
            'rules' => 'required|numeric',
        ],
        'satuan_id' => [
            'label' => 'Satuan',
            'rules' => 'required|integer',
        ],
        'jenis_id' => [
            'label' => 'Jenis',
            'rules' => 'required|integer',
        ],
        'cabang_id' => [
            'label' => 'Cabang',
            'rules' => 'required|integer',
        ],
    ];
    protected $validationMessages   = [
        'nama_material' => [
            'required' => 'Nama Material wajib diisi.',
            'max_length' => 'Nama Material maksimal 200 karakter.',
        ],
        'merek' => [
            'max_length' => 'Merek maksimal 100 karakter.',
        ],
        'harga' => [
            'required' => 'Harga wajib diisi.',
            'numeric' => 'Harga harus berupa angka.',
        ],
        'stok' => [
            'required' => 'Stok wajib diisi.',
            'numeric' => 'Stok harus berupa angka bulat.',
        ],
        'satuan_id' => [
            'required' => 'Satuan wajib diisi.',
            'integer' => 'Satuan harus berupa angka bulat.',
        ],
        'jenis_id' => [
            'required' => 'Jenis wajib diisi.',
            'integer' => 'Jenis harus berupa angka bulat.',
        ],
        'cabang_id' => [
            'required' => 'Cabang wajib diisi.',
            'integer' => 'Cabang harus berupa angka bulat.',
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
