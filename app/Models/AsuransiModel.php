<?php

namespace App\Models;

use CodeIgniter\Model;

class AsuransiModel extends Model
{
    protected $table            = 'asuransi';
    protected $primaryKey       = 'id_asuransi';
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
        'nama_asuransi' => [
            'label' => 'Nama Asuransi',
            'rules' => 'required|max_length[500]',
        ],
    ];
    protected $validationMessages   = [
        'nama_asuransi' => [
            'required'   => 'Field {field} wajib diisi.',
            'max_length' => 'Panjang maksimal {field} adalah 500 karakter.',
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
