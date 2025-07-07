<?php

namespace App\Models;

use CodeIgniter\Model;

class MekanikModel extends Model
{
    protected $table            = 'mekanik';
    protected $primaryKey       = 'id_mekanik';
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
        'nama_mekanik' => [
            'label' => 'Nama Mekanik',
            'rules' => 'required|max_length[200]',
        ],
        'no_handphone' => [
            'label' => 'No Handphone',
            'rules' => 'required|numeric|min_length[10]|max_length[20]',
        ],
        'cabang_id' => [
            'label' => 'Cabang',
            'rules' => 'required|integer',
        ],
    ];
    protected $validationMessages   = [
        'nama_mekanik' => [
            'required'   => 'Nama Mekanik wajib diisi.',
            'max_length' => 'Nama Mekanik maksimal 200 karakter.',
        ],
        'no_handphone' => [
            'required'   => 'No Handphone wajib diisi.',
            'numeric' => 'No Handphone harus angka.',
            'min_length' => 'No Handphone minimal 10 angka.',
            'max_length' => 'No Handphone maksimal 20 angka.',
        ],
        'cabang_id' => [
            'required' => 'Cabang wajib diisi.',
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
