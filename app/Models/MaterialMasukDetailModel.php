<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialMasukDetailModel extends Model
{
    protected $table            = 'material_masuk_detail';
    protected $primaryKey       = 'id_material_masuk_detail';
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
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'material_masuk_id' => [
            'label' => 'Material Masuk',
            'rules' => 'required|integer',
        ],
        'material_id' => [
            'label' => 'Material',
            'rules' => 'required|integer',
        ],
        'harga_masuk' => [
            'label' => 'Harga',
            'rules' => 'numeric',
        ],
        'stok_masuk' => [
            'label' => 'Stok',
            'rules' => 'numeric',
        ],
    ];
    protected $validationMessages   = [
        'material_masuk_id' => [
            'required' => 'Field Material Masuk wajib diisi.',
            'integer'  => 'Field Material Masuk harus berupa angka.',
        ],
        'material_id' => [
            'required' => 'Field Material wajib diisi.',
            'integer'  => 'Field Material harus berupa angka.',
        ],
        'harga_masuk' => [
            'numeric'  => 'Field Harga harus berupa angka.',
        ],
        'stok_masuk' => [
            'integer'  => 'Field Stok harus berupa angka.',
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
