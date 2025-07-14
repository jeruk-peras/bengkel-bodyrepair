<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitStatusHargaModel extends Model
{
    protected $table            = 'unit_status_harga';
    protected $primaryKey       = 'id_unit_status_harga';
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
        'nama_status' => [
            'label'  => 'Nama Status',
            'rules'  => 'required|max_length[100]',
        ],
        'harga_status' => [
            'label'  => 'Harga Status',
            'rules'  => 'required|numeric',
        ],
        'unit_id' => [
            'label'  => 'Unit ID',
            'rules'  => 'required|integer|max_length[11]',
        ],
    ];
    protected $validationMessages   = [
        'nama_status' => [
            'required'    => 'Nama Status wajib diisi.',
            'max_length'  => 'Nama Status maksimal 100 karakter.',
        ],
        'harga_status' => [
            'required' => 'Harga Status wajib diisi.',
            'numeric'  => 'Harga Status harus berupa angka.',
        ],
        'unit_id' => [
            'required'   => 'Unit ID wajib diisi.',
            'integer'    => 'Unit ID harus berupa angka bulat.',
            'max_length' => 'Unit ID maksimal 11 digit.',
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
