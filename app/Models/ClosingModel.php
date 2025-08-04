<?php

namespace App\Models;

use CodeIgniter\Model;

class ClosingModel extends Model
{
    protected $table            = 'closing';
    protected $primaryKey       = 'id_closing';
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
        'tanggal'         => 'required|valid_date',
        'periode_closing' => 'required|string|max_length[100]',
        'catatan'         => 'permit_empty|string',
        'cabang_id'       => 'required|integer',
    ];

    protected $validationMessages = [
        'tanggal' => [
            'required'   => 'Tanggal wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid.',
        ],
        'periode_closing' => [
            'required'    => 'Periode closing wajib diisi.',
            'max_length'  => 'Periode closing tidak boleh lebih dari 100 karakter.',
        ],
        'cabang_id' => [
            'required' => 'Cabang wajib dipilih.',
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
