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
        $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];

        $statusData = $this->db->table('unit_status_harga ush')
            ->select('ush.*')
            ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
            ->whereIn('cabang_id', $id_cabang)
            ->groupBy('ush.nama_status')
            ->orderBy('ush.id_unit_status_harga', 'ASC')
            ->get()->getResultArray();

        // total harga status
        $hargaStatusTotal = [];
        foreach ($statusData as $row) {
            $hargaStatusTotal[$row['nama_status']] = 0;
        }

        // data unit    
        $unitStatus = $this->db->table('unit')->whereIn('cabang_id', $id_cabang)->get()->getResultArray();

        $units = [];
        foreach ($unitStatus as $u) {
            //loop status unit
            $unitStatus = [];

            foreach ($statusData as $row) {

                $statusUnit = $this->db->table('unit_status_harga ush')
                    ->select('ush.nama_status, ush.harga_status')
                    ->join('unit_status s', 's.unit_status_harga_id = ush.id_unit_status_harga')
                    ->where('ush.unit_id', $u['id_unit'])
                    ->where('ush.nama_status', $row['nama_status'])->get()->getRowArray();

                // var_dump($statusUnit['nama_status'] ?? '');
                $statusUnit['nama_status'] = $statusUnit['nama_status'] ?? null;
                if ($statusUnit['nama_status'] !== null && $row['nama_status'] == $statusUnit['nama_status']) {

                    // jumlah panel * harga status
                    $totalUpah = ($u['jumlah_panel'] * $statusUnit['harga_status']);
                    ($hargaStatusTotal[$statusUnit['nama_status']] += $totalUpah);

                    $unitStatus[] = [
                        $row['nama_status'] => '',
                        'harga_status' => $statusUnit['harga_status'],
                        'total_harga_status' => $totalUpah,
                    ];
                } else {

                    $unitStatus[] = [
                        $row['nama_status'] => '-',
                        // jumlah panel * harga status
                        'harga_status' => '0',
                        'total_harga_status' => '0',
                    ];
                }
            }

            $units[] = [
                'cabang_id' => $u['cabang_id'],
                'nomor_spp' => $u['nomor_spp'],
                'nomor_polisi' => $u['nomor_polisi'],
                'model_unit' => $u['model_unit'],
                'warna_unit' => $u['warna_unit'],
                'total_upah_mekanik' => $u['total_upah_mekanik'],
                'jumlah_panel' => $u['jumlah_panel'],
                'status' => $unitStatus
            ];
        }

        $data = [
            'title' => $this->title . ' - Closing Mekanik',
            'status' => $statusData,
            'units' => $units,
            'harga_status_total' => $hargaStatusTotal
        ];

        return view('pages/laporan/closing_mekanik', $data);
    }

    public function status(int $id)
    {
        $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];

        // data all status
        $statusData = $this->db->table('unit_status_harga ush')
            ->groupBy('ush.nama_status')
            ->orderBy('ush.id_unit_status_harga', 'ASC')
            ->get()->getResultArray();

        $data = [];
        foreach ($statusData as $row) {
            $data[] = $row['nama_status'];
        }

        // total harga status
        $hargaStatusTotal = [];
        foreach ($statusData as $row) {
            $hargaStatusTotal[$row['nama_status']] = 0;
        }

        // data unit    
        $unitStatus = $this->db->table('unit')->whereIn('cabang_id', $id_cabang)->get()->getResultArray();

        $units = [];
        foreach ($unitStatus as $u) {
            //loop status unit
            $unitStatus = [];

            foreach ($statusData as $row) {

                $statusUnit = $this->db->table('unit_status_harga ush')
                    ->select('ush.nama_status, ush.harga_status')
                    ->join('unit_status s', 's.unit_status_harga_id = ush.id_unit_status_harga')
                    ->where('ush.unit_id', $u['id_unit'])
                    ->where('ush.nama_status', $row['nama_status'])->get()->getRowArray();

                // var_dump($statusUnit['nama_status'] ?? '');
                $statusUnit['nama_status'] = $statusUnit['nama_status'] ?? null;
                if ($statusUnit['nama_status'] !== null && $row['nama_status'] == $statusUnit['nama_status']) {

                    // jumlah panel * harga status
                    $totalUpah = ($u['jumlah_panel'] * $statusUnit['harga_status']);
                    ($hargaStatusTotal[$statusUnit['nama_status']] += $totalUpah);

                    $unitStatus[] = [
                        $row['nama_status'] => '',
                        'harga_status' => $statusUnit['harga_status'],
                        'total_harga_status' => $totalUpah,
                    ];
                } else {

                    $unitStatus[] = [
                        $row['nama_status'] => '-',
                        // jumlah panel * harga status
                        'harga_status' => '',
                        'total_harga_status' => '',
                    ];
                }
            }

            $units[] = [
                'cabang_id' => $u['cabang_id'],
                'nomor_spp' => $u['nomor_spp'],
                'nomor_polisi' => $u['nomor_polisi'],
                'total_upah_mekanik' => $u['total_upah_mekanik'],
                'jumlah_panel' => round($u['jumlah_panel'], 2),
                'status' => $unitStatus
            ];
        }

        // return view('pages/laporan/closing_mekanik', $data);
        return ResponseJSONCollection::success([$data, $units, $hargaStatusTotal], 'Sukes', ResponseInterface::HTTP_OK);
    }
}
