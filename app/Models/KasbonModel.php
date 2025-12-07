<?php

namespace App\Models;

use CodeIgniter\Model;

class KasbonModel extends Model
{
    protected $table            = 'kasbon';
    protected $primaryKey       = 'id_kasbon';
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
        'karyawan_id' => 'required|integer',
        'tanggal'     => 'required|valid_date[Y-m-d]',
        'alasan'      => 'required|max_length[1000]',
        'jumlah'      => 'required|numeric',
        'jenis'       => 'required|in_list[pinjam,bayar]',
        'status'      => 'required|in_list[pengajuan,terima,tolak]',
    ];

    protected $validationMessages = [
        'karyawan_id' => [
            'required' => 'Karyawan wajib diisi.',
            'integer'  => 'Karyawan harus berupa angka.',
        ],
        'tanggal' => [
            'required'   => 'Tanggal wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid. Gunakan Y-m-d.',
        ],
        'alasan' => [
            'required'   => 'Alasan wajib diisi.',
            'max_length' => 'Alasan terlalu panjang (maks 1000 karakter).',
        ],
        'jumlah' => [
            'required'                => 'Jumlah wajib diisi.',
            'numeric'                 => 'Jumlah harus berupa angka.',
        ],
        'jenis' => [
            'required' => 'Jenis wajib diisi.',
            'in_list'  => 'Jenis harus salah satu: pinjam, bayar.',
        ],
        'status' => [
            'required' => 'Status wajib diisi.',
            'in_list'  => 'Status harus salah satu: pengajuan, terima, tolak.',
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

    public function getPengajuan()
    {
        return $this->table('kasbon')
            ->select('kasbon.*, karyawan.nama_lengkap, cabang.nama_cabang')
            ->join('karyawan', 'karyawan.id_karyawan = kasbon.karyawan_id')
            ->join('cabang', 'cabang.id_cabang = karyawan.cabang_id')
            ->where('kasbon.status', 'pengajuan')
            ->orderBy('kasbon.tanggal', 'DESC')
            ->findAll();
    }

    public function getHistoriPengajuan($id_karyawan = '')
    {
        $builder = $this->db->table('kasbon');
        $builder->select('kasbon.*, karyawan.nama_lengkap, cabang.nama_cabang');
        $builder->join('karyawan', 'karyawan.id_karyawan = kasbon.karyawan_id');
        $builder->join('cabang', 'cabang.id_cabang = karyawan.cabang_id');

        // Filter cabang berdasarkan akses
        $akses = session('selected_akses');

        if (is_array($akses)) {
            $builder->whereIn('karyawan.cabang_id', $akses);
        } else {
            $builder->where('karyawan.cabang_id', $akses);
        }

        // Jika ingin filter berdasarkan id_karyawan
        if ($id_karyawan !== '') {
            $builder->where('karyawan.id_karyawan', $id_karyawan);
        }

        $builder->orderBy('kasbon.tanggal', 'DESC');

        return $builder->get()->getResultArray();
    }


    public function getKasbonKaryawan($id_karyawan)
    {
        return $this->table('kasbon')
            ->select('kasbon.*, karyawan.nama_lengkap')
            ->join('karyawan', 'karyawan.id_karyawan = kasbon.karyawan_id')
            ->where('kasbon.status', 'terima')
            ->where('kasbon.karyawan_id', $id_karyawan)
            ->orderBy('kasbon.tanggal', 'ASC')   // HARUS ASC supaya running balance benar
            ->findAll();
    }

    public function dataKasbonKaryawan($id_karyawan)
    {
        $kasonKaryawan = $this->getKasbonKaryawan($id_karyawan);

        $data = [];
        $utang = 0;

        foreach ($kasonKaryawan as $row) {

            $pinjam = $row['jenis'] == 'pinjam' ? $row['jumlah'] : 0;
            $bayar = $row['jenis'] == 'bayar' ? $row['jumlah'] : 0;

            $utang += $row['jenis'] == 'pinjam' ? $row['jumlah'] : '-' . $row['jumlah'];

            $data[] = [
                'id_karyawan' => $row['karyawan_id'],
                'nama_karyawan' => $row['nama_lengkap'],
                'tanggal' => $row['tanggal'],
                'pinjam' => $pinjam,
                'bayar' => $bayar,
                'utang' => $utang,
                'keterangan' => $row['alasan'],
            ];
        }

        return $data;
    }

    public function getKaryawan()
    {
        $builder = $this->db->table('karyawan');
        $builder->select('nama_cabang, nip, nama_lengkap, jabatan');
        $builder->join('cabang', 'cabang.id_cabang = karyawan.cabang_id');

        $akses = session('selected_akses');

        if (is_array($akses)) {
            $builder->whereIn('karyawan.cabang_id', $akses);
        } else {
            $builder->where('karyawan.cabang_id', $akses);
        }

        $builder->where('status', '1');

        return $builder->get()->getResultArray();
    }

    public function getDataPembayaran($cabangId, $komponenId, $gajiId)
    {
        $builder = $this->db->table('gaji_detail gd');
        $builder->select('c.nama_cabang, k.nip, k.id_karyawan, k.nama_lengkap, k.jabatan, gd.nilai, kg.nama_komponen_gaji');
        $builder->join('komponen_gaji kg', 'kg.id_komponen_gaji = gd.komponen_gaji_id');
        $builder->join('karyawan k', 'k.id_karyawan = gd.karyawan_id');
        $builder->join('cabang c', 'c.id_cabang = k.cabang_id');

        $builder->where('c.id_cabang', $cabangId);
        $builder->where('kg.id_komponen_gaji', $komponenId);
        $builder->where('gd.gaji_id', $gajiId);

        return $builder->get()->getResultArray();
    }
}
