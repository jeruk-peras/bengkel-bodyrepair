<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitMaterialModel extends Model
{
    protected $table            = 'unit_material';
    protected $primaryKey       = 'id_unit_material';
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
        'material_id'   => 'required|integer',
        'tanggal'       => 'required|valid_date[Y-m-d H:i:s]',
        'harga'         => 'required|numeric',
        'jumlah'        => 'required|integer',
        'detail_jumlah' => 'required|string|max_length[100]',
        'mekanik_id'    => 'required|integer',
        'unit_id'       => 'required|integer',
    ];
    protected $validationMessages   = [
        'material_id' => [
            'required' => 'Material harus diisi.',
            'integer'  => 'Material harus berupa angka.',
        ],
        'tanggal' => [
            'required'   => 'Tanggal harus diisi.',
            'valid_date' => 'Format tanggal tidak valid (Y-m-d H:i:s).',
        ],
        'harga' => [
            'required' => 'Harga harus diisi.',
            'numeric'  => 'Harga harus berupa angka.',
        ],
        'jumlah' => [
            'required' => 'Jumlah harus diisi.',
            'integer'  => 'Jumlah harus berupa angka.',
        ],
        'detail_jumlah' => [
            'required'   => 'Detail jumlah harus diisi.',
            'string'     => 'Detail jumlah harus berupa teks.',
            'max_length' => 'Detail jumlah maksimal 100 karakter.',
        ],
        'mekanik_id' => [
            'required' => 'Mekanik harus diisi.',
            'integer'  => 'Mekanik harus berupa angka.',
        ],
        'unit_id' => [
            'required' => 'Unit harus diisi.',
            'integer'  => 'Unit harus berupa angka.',
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
