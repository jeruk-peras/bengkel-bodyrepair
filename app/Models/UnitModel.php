<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table            = 'unit';
    protected $primaryKey       = 'id_unit';
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
        'nama_customer'     => 'required|max_length[100]',
        'no_handphone'      => 'required|max_length[20]',
        'alamat'            => 'required',
        'nomor_polisi'      => 'required|max_length[50]',
        'model_unit'        => 'required|max_length[100]',
        'warna_unit'        => 'required|max_length[100]',
        'asuransi_id'          => 'required|max_length[100]',
        'nomor_mesin'       => 'required|max_length[100]',
        'nomor_rangka'      => 'required|max_length[100]',
        'nomor_spp'         => 'required|max_length[100]',
        'tanggal_masuk'     => 'required|valid_date',
        'estimasi_selesai'  => 'required|valid_date',
        'detail_pengerjaan' => 'required',
        'harga_spp'         => 'required|numeric',
        'diskon'            => 'required|integer',
        'jumlah_diskon'     => 'required|numeric',
        'harga_panel'       => 'required|numeric',
        'jumlah_panel'      => 'required|numeric',
        'upah_mekanik'      => 'required|numeric',
        'total_upah_mekanik'=> 'required|numeric',
        'status'            => 'required|integer',
        'cabang_id'         => 'required|integer',
    ];
    protected $validationMessages   = [
        'nama_customer' => [
            'required'   => 'Nama customer wajib diisi.',
            'max_length' => 'Nama customer maksimal 100 karakter.',
        ],
        'no_handphone' => [
            'required'   => 'No handphone wajib diisi.',
            'max_length' => 'No handphone maksimal 20 karakter.',
        ],
        'alamat' => [
            'required'   => 'Alamat wajib diisi.',
        ],
        'nomor_polisi' => [
            'required'   => 'Nomor polisi wajib diisi.',
            'max_length' => 'Nomor polisi maksimal 50 karakter.',
        ],
        'model_unit' => [
            'required'   => 'Model unit wajib diisi.',
            'max_length' => 'Model unit maksimal 100 karakter.',
        ],
        'warna_unit' => [
            'required'   => 'Warna unit wajib diisi.',
            'max_length' => 'Warna unit maksimal 100 karakter.',
        ],
        'asuransi_id' => [
            'required'   => 'Asuransi wajib diisi.',
            'max_length' => 'Asuransi maksimal 100 karakter.',
        ],
        'nomor_mesin' => [
            'required'   => 'Nomor mesin wajib diisi.',
            'max_length' => 'Nomor mesin maksimal 100 karakter.',
        ],
        'nomor_rangka' => [
            'required'   => 'Nomor rangka wajib diisi.',
            'max_length' => 'Nomor rangka maksimal 100 karakter.',
        ],
        'nomor_spp' => [
            'required'   => 'Nomor SPP wajib diisi.',
            'max_length' => 'Nomor SPP maksimal 100 karakter.',
        ],
        'tanggal_masuk' => [
            'required'    => 'Tanggal masuk wajib diisi.',
            'valid_date'  => 'Tanggal masuk tidak valid.',
        ],
        'estimasi_selesai' => [
            'required'    => 'Estimasi selesai wajib diisi.',
            'valid_date'  => 'Estimasi selesai tidak valid.',
        ],
        'detail_pengerjaan' => [
            'required'   => 'Detail pengerjaan wajib diisi.',
        ],
        'harga_spp' => [
            'required'   => 'Harga SPP wajib diisi.',
            'numeric'    => 'Harga SPP harus berupa angka.',
        ],
        'diskon' => [
            'required'   => 'Diskon wajib diisi.',
            'integer'    => 'Diskon harus berupa angka bulat.',
        ],
        'jumlah_diskon' => [
            'required'   => 'Jumlah diskon wajib diisi.',
            'numeric'    => 'Jumlah diskon harus berupa angka.',
        ],
        'harga_panel' => [
            'required'   => 'Harga panel wajib diisi.',
            'numeric'    => 'Harga panel harus berupa angka.',
        ],
        'jumlah_panel' => [
            'required'   => 'Jumlah panel wajib diisi.',
            'numeric'    => 'Harga panel harus berupa angka.',
        ],
        'upah_mekanik' => [
            'required'   => 'Upah mekanik wajib diisi.',
            'numeric'    => 'Upah mekanik harus berupa angka.',
        ],
        'total_upah_mekanik' => [
            'required'   => 'Total upah mekanik wajib diisi.',
            'numeric'    => 'Total upah mekanik harus berupa angka.',
        ],
        'status' => [
            'required'   => 'Status wajib diisi.',
            'integer'    => 'Status harus berupa angka bulat.',
        ],
        'cabang_id' => [
            'required'   => 'Cabang wajib diisi.',
            'integer'    => 'Cabang harus berupa angka bulat.',
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

    function generateNoOrder()
    {
        $prefix = 'UNT';
        $tahun = date('Y');
        $bulan = date('m');

        // Ambil nomor urut terakhir bulan ini dari database
        $db = \Config\Database::connect();
        $builder = $db->table('unit');
        $builder->selectMax('nomor_spp');
        $builder->where('YEAR(created_at)', $tahun);
        $builder->where('MONTH(created_at)', $bulan);
        $last = $builder->get()->getRow();

        $noUrut = ($last && $last->nomor_spp) ? (substr($last->nomor_spp, 12, 4) + 1) : 1;
        $noUrutStr = str_pad($noUrut, 4, '0', STR_PAD_LEFT);
        return "{$prefix}.{$tahun}.{$bulan}.{$noUrutStr}";
    }
}
