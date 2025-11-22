<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table            = 'gaji';
    protected $primaryKey       = 'id_gaji';
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
        'tanggal' => 'required|valid_date',
        'periode' => 'required|trim|max_length[200]',
    ];

    protected $validationMessages = [
        'tanggal' => [
            'required'   => 'Tanggal harus diisi.',
            'valid_date' => 'Format tanggal tidak valid',
        ],
        'periode' => [
            'required'   => 'Periode harus diisi.',
            'max_length' => 'Periode maksimal 200 karakter.',
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

    public function saveDetailGaji(int $id_gaji)
    {

        $dataKaryawanAktif = $this->db->table('karyawan')->where('status', 1)->get()->getResultArray();
        $dataKomponenGaji = $this->db->table('komponen_gaji')->get()->getResultArray();

        // set bacth save data
        $data = [];
        foreach ($dataKaryawanAktif as $karyawan) {
            foreach ($dataKomponenGaji as $komponen) {
                $data[] = [
                    'gaji_id' => $id_gaji,
                    'karyawan_id' => $karyawan['id_karyawan'],
                    'komponen_gaji_id' => $komponen['id_komponen_gaji'],
                    'nilai' => 0,
                ];
            }
        }

        // save data
        $save = $this->db->table('gaji_detail')->insertBatch($data);

        return $save;
    }

    public function detailGaji($id, $id_karyawan = '')
    {
        $db = \Config\Database::connect();

        $query = $db->table('gaji_detail gd')
            ->select('g.periode, gd.gaji_id, c.nama_cabang, k.id_karyawan, k.nama_lengkap, k.nip, k.jabatan, k.status, k.dapartemen, k.cabang_id, kg.id_komponen_gaji, kg.nama_komponen_gaji, kg.jenis, gd.nilai')
            ->join('komponen_gaji kg', 'kg.id_komponen_gaji = gd.komponen_gaji_id')
            ->join('gaji g', 'g.id_gaji = gd.gaji_id')
            ->join('karyawan k', 'k.id_karyawan = gd.karyawan_id')
            ->join('cabang c', 'c.id_cabang = k.cabang_id')
            ->where('gd.gaji_id', $id)
            ->when($id_karyawan, function ($query, $id_karyawan) {
                $query->where('k.id_karyawan', $id_karyawan);
            })
            ->orderBy('k.id_karyawan, kg.jenis, kg.id_komponen_gaji')->get();

        $rows = $query->getResultArray();

        $result = [];

        $data = [
            "pendapatan"  => [],
            "potongan"    => []
        ];

        $kid = 0;
        foreach ($rows as $row) {

            if ($kid != $row['id_karyawan']) {
                $pendapatan = 0;
                $potongan = 0;
            }
            $kid = $row['id_karyawan'];

            if (!isset($result[$kid])) {
                $result[$kid] = [
                    "id_gaji"     => $row['gaji_id'],
                    "periode"     => $row['periode'],
                    "id_karyawan" => $row['id_karyawan'],
                    "nama_lengkap"  => $row['nama_lengkap'],
                    "jabatan"  => $row['jabatan'],
                    "status"  => $row['status'],
                    "dapartemen"  => $row['dapartemen'],
                    "nip"         => $row['nip'],
                    "cabang_id"   => $row['cabang_id'],
                    "cabang"      => $row['nama_cabang'],
                    "pendapatan"  => [],
                    "potongan"    => []
                ];
            }

            if ($row['jenis'] == "Pendapatan") {
                $result[$kid]["pendapatan"][$row['id_komponen_gaji']] = $row['nilai'];
                $pendapatan += $row['nilai'];

                if (!in_array($row['nama_komponen_gaji'], $data['pendapatan'])) {
                    $data['pendapatan'][$row['id_komponen_gaji']] = $row['nama_komponen_gaji'];
                }
            } else {
                $result[$kid]["potongan"][$row['id_komponen_gaji']] = $row['nilai'];
                $potongan += $row['nilai'];

                if (!in_array($row['nama_komponen_gaji'], $data['potongan'])) {
                    $data['potongan'][$row['id_komponen_gaji']] = $row['nama_komponen_gaji'];
                }
            }

            // total gaji
            $result[$kid]['total_pendapatan'] = $pendapatan;
            $result[$kid]['total_potongan'] = $potongan;
            $result[$kid]['total_gaji'] = $pendapatan - $potongan;
        }

        return [
            "karyawan"   => $result,
            "komponen"   => $data
        ];
    }
}
