<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitStatusModel extends Model
{
    protected $table            = 'unit_status';
    protected $primaryKey       = 'id_unit_status';
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
        'tanggal_update' => 'required|valid_date',
        'unit_status_harga_id' => 'required|integer',
        'catatan' => 'permit_empty|string',
        'gambar_status' => 'permit_empty|max_length[100]',
        'unit_id' => 'required|integer',
    ];
    protected $validationMessages   = [
        'tanggal_update' => [
            'required' => 'Tanggal update wajib diisi.',
            'valid_date' => 'Format tanggal update tidak valid.',
        ],
        'unit_status_harga_id' => [
            'required' => 'Unit status harga wajib diisi.',
            'integer' => 'Unit status harga harus berupa angka.',
        ],
        'catatan' => [
            'string' => 'Catatan harus berupa teks.',
        ],
        'gambar_status' => [
            'max_length' => 'Gambar status maksimal 100 karakter.',
        ],
        'unit_id' => [
            'required' => 'Unit wajib diisi.',
            'integer' => 'Unit harus berupa angka.',
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
