<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard', $data);
    }

    public function widgetClosing()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tanggal_awal = $this->request->getPost('filterTanggal')['tanggal_awal'];
            $tanggal_akhir = $this->request->getPost('filterTanggal')['tanggal_akhir'];

            $statusData = $this->db->table('unit_status_harga ush')
                ->select('ush.*')
                ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
                ->whereIn('cabang_id', $id_cabang)
                ->where('u.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"')
                ->groupBy('ush.nama_status')
                ->orderBy('ush.urutan', 'ASC')
                ->get()->getResultArray();

            // total harga status
            $total_upah = [];
            foreach ($statusData as $row) {
                $total_upah[$row['nama_status']] = 0;
            }

            // total panel
            $total_panel = [];
            foreach ($statusData as $row) {
                $total_panel[$row['nama_status']] = 0;
            }

            // data unit    
            $unitStatus = $this->db->table('unit')
                ->select('unit.*, cabang.nama_cabang')
                ->join('cabang', 'cabang.id_cabang = unit.cabang_id', 'left')
                ->whereIn('unit.cabang_id', $id_cabang)
                ->where('unit.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"')
                ->get()->getResultArray();

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


                    $statusUnit['nama_status'] = $statusUnit['nama_status'] ?? null; // jika nama status tidak ditemukan maka set null
                    if ($statusUnit['nama_status'] !== null && $row['nama_status'] == $statusUnit['nama_status']) {

                        // jumlah panel * harga status
                        $totalUpah = ($u['jumlah_panel'] * $statusUnit['harga_status']);
                        ($total_upah[$statusUnit['nama_status']] += $totalUpah);

                        // jumlah panel
                        ($total_panel[$statusUnit['nama_status']] += $u['jumlah_panel']);
                    }
                }
            }

            $data = [
                'status' => $statusData,
                'total_panel' => $total_panel,
                'total_upah' => $total_upah
            ];

            // return;

            return ResponseJSONCollection::success(['html' => view('side_dashboard_closing', $data)], 'Data ditemukan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }


    public function widgetData()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tanggal_awal = $this->request->getPost('filterTanggal')['tanggal_awal'];
            $tanggal_akhir = $this->request->getPost('filterTanggal')['tanggal_akhir'];

            $dataUnit = $this->db->table('unit')->whereIn('cabang_id', $id_cabang)->where('unit.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"');

            $data = [
                'total_panel' => 0,
                'unit_proses' => 0,
                'unit_selesai' => 0,
                'total_nilai' => 0,
            ];

            $result = $dataUnit->get()->getResultArray();
            foreach ($result as $row) {

                $data['total_panel'] += $row['jumlah_panel'];
                $data['total_nilai'] += $row['harga_spp'];
                $data['unit_proses'] += ($row['status'] == 0 ? 1 : 0);
                $data['unit_selesai'] += ($row['status'] == 1 ? 1 : 0);
            }

            $data = [
                'total_panel' => round($data['total_panel'], 2),
                'unit_proses' => $data['unit_proses'],
                'unit_selesai' => $data['unit_selesai'],
                'total_nilai' => number_format($data['total_nilai']),
            ];


            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {

            return ResponseJSONCollection::error([$e], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function grafikPendapatan()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tahun = $this->request->getPost('filterTahun')['tahun'];

            // data cabang
            $dataCabang = $this->db->table('cabang')->select('id_cabang, nama_cabang')->whereIn('id_cabang', $id_cabang)
                ->get()->getResultArray();

            $periode = $this->request->getGet('periode');
            // periode bulan
            // $per1 = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun'];
            // $per2 = [7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
            // $periode = ($periode == 1) ? $per1 : $per2;

            $periode = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

            // data unit
            $dataUnit = $this->db->table('unit')->whereIn('cabang_id', $id_cabang);

            $data = [];
            foreach ($dataCabang as $k => $cab) {
                $data[$k] = [
                    'name' => $cab['nama_cabang'],
                ];

                // loping data sesuai dengan bulan
                foreach ($periode as $key => $bulan) {
                    $total_spp = $dataUnit->selectSum('harga_spp')->where('cabang_id', $cab['id_cabang'])
                        ->where('MONTH(tanggal_masuk)', $key)->where('YEAR(tanggal_masuk)', $tahun)->get()->getRowArray();

                    $data[$k]['data'][] = $total_spp['harga_spp'] ?? 0;
                }
            }

            // looping bulan untuk kebutuhan grafik
            $per = [];
            foreach ($periode as $key => $bulan) {
                $per[] = $bulan;
            }

            $data = [
                'title' => 'GRAFIK PENDAPATAN PER BULAN PER CABANG',
                'data' => $data,
                'periode' => $per,
            ];

            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {

            return ResponseJSONCollection::error([$e], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function grafikPendapatanPerbulan()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tahun = $this->request->getPost('filterTahun')['tahun'];

            // periode bulan
            $periode = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

            // data unit
            $dataUnit = $this->db->table('unit');

            $data = [];
            $total = 0;
            // loping data sesuai dengan bulan
            foreach ($periode as $key => $bulan) {
                $total_spp = $dataUnit->selectSum('harga_spp')->whereIn('cabang_id', $id_cabang)
                    ->where('MONTH(tanggal_masuk)', $key)->where('YEAR(tanggal_masuk)', $tahun)
                    ->get()->getRowArray();

                $total = $total_spp['harga_spp'] ?? 0;
                $data[] = $total ?? 0;
            }

            // looping bulan untuk kebutuhan grafik
            $per = [];
            foreach ($periode as $key => $bulan) {
                $per[] = $bulan;
            }

            $data = [
                'title' => 'GRAFIK PENDAPATAN PER BULAN',
                'data' => $data,
                'periode' => $per,
            ];

            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {

            return ResponseJSONCollection::error([$e], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function grafikMaterial()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tanggal_awal = $this->request->getPost('filterTanggal')['tanggal_awal'];
            $tanggal_akhir = $this->request->getPost('filterTanggal')['tanggal_akhir'];

            $dataJenis = $this->db->table('jenis')->get()->getResultArray();

            $jenisData = [];
            $jenisName = [];
            $total = 0;
            foreach ($dataJenis as $row) {
                // count data jenis / penggunaan material
                $dataUnit = $this->db->table('unit u');
                $dataUnit->selectCount('m.jenis_id');
                $dataUnit->join('unit_material um', 'um.unit_id = u.id_unit');
                $dataUnit->join('material m', 'm.id_material = um.material_id');
                $dataUnit->whereIn('u.cabang_id', $id_cabang);
                $dataUnit->where('u.tanggal_masuk BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"');
                $totalPemakaian = $dataUnit->where('m.jenis_id', $row['id_jenis'])->get()->getRowArray();

                $jenisName[] = $row['nama_jenis'];
                $jenisData[] = $totalPemakaian['jenis_id'];

                $total += (int) $totalPemakaian['jenis_id'] ?? 0;
            }

            $persentaseData = [];
            foreach ($jenisData as $j) {
                $persentase = $total > 0 ? round(($j / $total) * 100, 2) : 0;
                $persentaseData[] = $persentase;
            }

            $data = [
                'title' => 'GRAFIK PENGGUNAAN MATERIAL',
                'name' => $jenisName,
                'data' => $persentaseData
            ];

            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {

            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
}
