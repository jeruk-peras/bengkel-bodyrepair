<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id_karyawan';
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
    protected $validationRules = [
        'nama_lengkap'         => 'required|max_length[200]',
        'no_ktp'               => 'required|numeric|exact_length[16]',
        'tempat_lahir'         => 'required|max_length[100]',
        'tanggal_lahir'        => 'required|valid_date[Y-m-d]',
        'jenis_kelamin'        => 'required|in_list[Laki-Laki,Perempuan]',
        'alamat'               => 'required',
        'nip'                  => 'required|max_length[16]',
        'jabatan'              => 'required|in_list[Admin,Group Head,Mekanik]',
        'dapartemen'           => 'required|max_length[100]',
        'tanggal_mulai_kerja'  => 'permit_empty|valid_date[Y-m-d]',
        'status'               => 'required|integer',
        'no_hp'                => 'permit_empty|numeric|min_length[8]|max_length[16]',
        'email'                => 'permit_empty|valid_email|max_length[100]',
        'cabang_id'            => 'required|integer',
    ];

    protected $validationMessages = [
        'nama_lengkap' => [
            'required'   => 'Nama lengkap wajib diisi.',
            'max_length' => 'Nama lengkap maksimal 200 karakter.',
        ],
        'no_ktp' => [
            'required'     => 'No. KTP wajib diisi.',
            'numeric'      => 'No. KTP hanya boleh berisi angka.',
            'exact_length' => 'No. KTP harus terdiri dari 16 digit.',
        ],
        'tempat_lahir' => [
            'required'   => 'Tempat lahir wajib diisi.',
            'max_length' => 'Tempat lahir maksimal 100 karakter.',
        ],
        'tanggal_lahir' => [
            'required'   => 'Tanggal lahir wajib diisi.',
            'valid_date' => 'Format tanggal lahir tidak valid (YYYY-MM-DD).',
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin wajib dipilih.',
            'in_list'  => 'Pilihan jenis kelamin tidak valid.',
        ],
        'alamat' => [
            'required' => 'Alamat wajib diisi.',
        ],
        'nip' => [
            'required'   => 'NIP wajib diisi.',
            'max_length' => 'NIP harus terdiri dari 16 digit.',
        ],
        'jabatan' => [
            'required' => 'Jabatan wajib dipilih.',
            'in_list'  => 'Pilihan jabatan tidak valid.',
        ],
        'dapartemen' => [
            'required'   => 'Dapartemen wajib diisi.',
            'max_length' => 'Dapartemen maksimal 100 karakter.',
        ],
        'tanggal_mulai_kerja' => [
            'valid_date' => 'Format tanggal mulai kerja tidak valid (YYYY-MM-DD).',
        ],
        'status' => [
            'required' => 'Status wajib diisi.',
            'integer'  => 'Status harus berupa angka.',
        ],
        'no_hp' => [
            'numeric'    => 'No. HP hanya boleh berisi angka.',
            'min_length' => 'No. HP minimal 8 digit.',
            'max_length' => 'No. HP maksimal 16 digit.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
            'max_length'  => 'Email maksimal 100 karakter.',
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
