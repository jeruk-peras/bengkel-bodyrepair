<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialMasukModel extends Model
{
    protected $table            = 'material_masuk';
    protected $primaryKey       = 'id_material_masuk';
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
        'tanggal' => [
            'label' => 'Tanggal',
            'rules' => 'required|valid_date',
        ],
        'no_delivery' => [
            'label' => 'No Delivery',
            'rules' => 'required|max_length[100]',
        ],
        'suplier' => [
            'label' => 'Suplier',
            'rules' => 'required|max_length[100]',
        ],
        'total_harga' => [
            'label' => 'Total Harga',
            'rules' => 'required|numeric',
        ],
        'catatan' => [
            'label' => 'Catatan',
            'rules' => 'permit_empty|string',
        ],
        'cabang_id' => [
            'label' => 'Cabang',
            'rules' => 'required|integer',
        ],
    ];
    protected $validationMessages   = [
        'tanggal' => [
            'required'    => 'Tanggal harus diisi.',
            'valid_date'  => 'Format tanggal tidak valid.',
        ],
        'no_delivery' => [
            'required'    => 'No Delivery harus diisi.',
            'max_length'  => 'No Delivery maksimal 100 karakter.',
        ],
        'suplier' => [
            'required'    => 'Suplier harus diisi.',
            'max_length'  => 'Suplier maksimal 100 karakter.',
        ],
        'total_harga' => [
            'required'    => 'Total Harga harus diisi.',
            'numeric'     => 'Total Harga harus berupa angka.',
        ],
        'catatan' => [
            'string'      => 'Catatan harus berupa teks.',
        ],
        'cabang_id' => [
            'required'    => 'Cabang harus diisi.',
            'integer'     => 'Cabang harus berupa angka.',
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
