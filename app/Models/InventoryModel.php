<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table            = 'inventory';
    protected $primaryKey       = 'id_inventory';
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
        'nama_barang' => [
            'rules' => 'required|max_length[100]',
            'label' => 'Nama Barang'
        ],
        'deskripsi' => [
            'label' => 'Deskripsi',
            'rules' => 'permit_empty|string',
        ],
        'gambar' => [
            'rules' => 'permit_empty|max_length[400]',
            'label' => 'Gambar'
        ],
    ];
    protected $validationMessages   = [
        'nama_barang' => [
            'required'    => 'Nama Barang wajib diisi.',
            'max_length'  => 'Nama Barang maksimal 100 karakter.'
        ],
        'deskripsi' => [
            'string' => 'Deskripsi harus berupa teks.',
        ],
        'gambar' => [
            'max_length'  => 'Gambar maksimal 400 karakter.'
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
