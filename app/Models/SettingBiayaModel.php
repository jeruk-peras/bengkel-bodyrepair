<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingBiayaModel extends Model
{
    protected $table            = 'setting_biaya';
    protected $primaryKey       = 'id_setting_biaya';
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
        'id_setting_biaya' => 'string',
        'diskon' => [
            'rules' => 'required|integer|max_length[3]',
            'label' => 'Diskon',
        ],
        'harga_panel' => [
            'rules' => 'required|numeric',
            'label' => 'Harga Panel',
        ],
        'upah_mekanik' => [
            'rules' => 'required|numeric',
            'label' => 'Upah Mekanik',
        ],
        'sharing' => [
            'rules' => 'required|integer|max_length[3]',
            'label' => 'Sharing',
        ],
        'cabang_id' => [
            'rules' => 'required|integer|is_unique[setting_biaya.cabang_id,id_setting_biaya,{id_setting_biaya}]',
            'label' => 'Cabang',
        ],
    ];
    protected $validationMessages   = [
        'diskon' => [
            'required'   => 'Field {field} wajib diisi.',
            'integer'    => 'Field {field} harus berupa angka bulat.',
            'max_length' => 'Field {field} maksimal 3 digit.',
        ],
        'harga_panel' => [
            'required' => 'Field {field} wajib diisi.',
            'numeric'  => 'Field {field} harus berupa angka.',
        ],
        'upah_mekanik' => [
            'required' => 'Field {field} wajib diisi.',
            'numeric'  => 'Field {field} harus berupa angka.',
        ],
        'sharing' => [
            'required'   => 'Field {field} wajib diisi.',
            'integer'    => 'Field {field} harus berupa angka bulat.',
            'max_length' => 'Field {field} maksimal 3 digit.',
        ],
        'cabang_id' => [
            'required'   => 'Field {field} wajib diisi.',
            'integer'    => 'Field {field} harus berupa angka bulat.',
            'max_length' => 'Field {field} maksimal 11 digit.',
            'is_unique'  => '{field} sudah digunakan, tidak diijinkan untuk menamabah data.',
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
