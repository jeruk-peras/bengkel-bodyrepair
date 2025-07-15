<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{
    private $title = 'Laporan';

    public function __construct() {}

    public function closingMekanik()
    {
        $data = [
            'title' => $this->title . ' - Closing Mekanik',
        ];

        return view('pages/laporan/closing_mekanik', $data,);
    }

    public function sideDataClosingMekanik()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tanggal_awal = $this->request->getPost('tanggal_awal');
            $tanggal_akhir = $this->request->getPost('tanggal_akhir');

            $statusData = $this->db->table('unit_status_harga ush')
                ->select('ush.*')
                ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
                ->whereIn('cabang_id', $id_cabang)
                ->where('u.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"')
                ->groupBy('ush.nama_status')
                ->orderBy('ush.urutan', 'ASC')
                ->get()->getResultArray();

            // total harga status
            $hargaStatusTotal = [];
            foreach ($statusData as $row) {
                $hargaStatusTotal[$row['nama_status']] = 0;
            }

            // data unit    
            $unitStatus = $this->db->table('unit')
                ->select('unit.*, cabang.nama_cabang')
                ->join('cabang', 'cabang.id_cabang = unit.cabang_id', 'left')
                ->whereIn('unit.cabang_id', $id_cabang)
                ->where('unit.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"')
                ->get()->getResultArray();

            $units = [];
            $i = 1;
            foreach ($unitStatus as $u) {
                //loop status unit
                $unitStatus = [];

                foreach ($statusData as $row) {

                    $statusUnit = $this->db->table('unit_status_harga ush')
                        ->select('ush.nama_status, ush.harga_status')
                        ->join('unit_status s', 's.unit_status_harga_id = ush.id_unit_status_harga')
                        ->where('ush.unit_id', $u['id_unit'])
                        ->orderBy('ush.urutan', 'ASC')
                        ->where('ush.nama_status', $row['nama_status'])->get()->getRowArray();

                    $statusUnit['nama_status'] = $statusUnit['nama_status'] ?? null;
                    if ($statusUnit['nama_status'] !== null && $row['nama_status'] == $statusUnit['nama_status']) {

                        // jumlah panel * harga status
                        $totalUpah = ($u['jumlah_panel'] * $statusUnit['harga_status']);
                        ($hargaStatusTotal[$statusUnit['nama_status']] += $totalUpah);

                        $unitStatus[] = [
                            $row['nama_status'] => $row['nama_status'],
                            'harga_status' => $statusUnit['harga_status'],
                            'total_harga_status' => $totalUpah,
                        ];
                    } else {
                        // jika status belum di set di unit
                        $unitStatus[] = [
                            $row['nama_status'] => '-',
                            'harga_status' => '0',
                            'total_harga_status' => '0',
                        ];
                    }
                }

                // array data unit
                $units[] = [
                    'no' => $i++,
                    'cabang_id' => $u['nama_cabang'],
                    'nomor_spp' => $u['nomor_spp'],
                    'nomor_polisi' => $u['nomor_polisi'],
                    'model_unit' => $u['model_unit'],
                    'warna_unit' => $u['warna_unit'],
                    'upah_mekanik' => $u['upah_mekanik'],
                    'total_upah_mekanik' => $u['total_upah_mekanik'],
                    'jumlah_panel' => $u['jumlah_panel'],
                    'status' => $unitStatus
                ];
            }

            $data = [
                'status' => $statusData,
                'units' => $units,
                'harga_status_total' => $hargaStatusTotal
            ];

            return ResponseJSONCollection::success(['html' => view('pages/laporan/side_closingan_mekanik', $data,)], 'Data ditemukan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
}
