<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class DashboardController extends BaseController
{

    protected $_tahun;
    protected $_periode;

    public function __construct()
    {
        $this->_tahun = date("Y");
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard', $data);
    }

    private function _periode($tahun)
    {
        $periode = [];
        $start = new DateTime("$tahun-01-01");
        $end = new DateTime("$tahun-12-01");
        $i = 1;
        while ($start <= $end) {
            $periode[$i++] = $start->format("F") . ' - ' . $start->format("Y");
            $start->modify("+1 month");
        }
        return $periode;
    }

    public function widgetClosing()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];

            // agar tidak menghitung unit yang closing
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->getCompiledSelect();

            $statusData = $this->db->table('unit_status_harga ush')
                ->select('ush.*')
                ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
                ->whereIn('cabang_id', $id_cabang)
                ->where("u.id_unit NOT IN ($subQuery)")
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
                ->where("unit.id_unit NOT IN ($subQuery)")
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
                'total_upah' => $total_upah,
            ];

            return ResponseJSONCollection::success(['html' => view('side_dashboard_closing', $data)], 'Data ditemukan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function widgetData()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];

            // agar tidak menghitung unit yang closing
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->getCompiledSelect();

            $dataUnit = $this->db->table('unit')->whereIn('cabang_id', $id_cabang)->where("id_unit NOT IN ($subQuery)");

            $getShating = $this->db->table('setting_biaya')
            ->when(is_array($this->id_cabang), function ($query) {
                $query->where('cabang_id', 1);
            }, function ($query) {
                $query->where('cabang_id', $this->id_cabang);
            })->get()->getRowArray()['sharing'] ?? 0;

            $data = [
                'total_panel' => 0,
                'total_upah' => 0,
                'unit_proses' => 0,
                'panel_proses' => 0,
                'unit_selesai' => 0,
                'panel_selesai' => 0,
                'total_nilai' => 0,
                'total_sharing' => 0,
            ];

            $result = $dataUnit->get()->getResultArray();
            foreach ($result as $row) {

                $data['total_panel'] += $row['jumlah_panel'];
                $data['total_nilai'] += $row['jumlah_diskon'];
                $data['total_upah'] += $row['total_upah_mekanik'];

                $data['unit_proses'] += ($row['status'] == 0 ? 1 : 0);
                $data['panel_proses'] += ($row['status'] == 0 ? $row['jumlah_panel'] : 0);

                $data['unit_selesai'] += ($row['status'] == 1 ? 1 : 0);
                $data['panel_selesai'] += ($row['status'] == 1 ? $row['jumlah_panel'] : 0);
            }

            $percent = $getShating / 100;

            $data = [
                'total_panel' => round($data['total_panel'], 2),
                'unit_proses' => $data['unit_proses'],
                'panel_proses' => round($data['panel_proses'], 2),
                'unit_selesai' => $data['unit_selesai'],
                'panel_selesai' => round($data['panel_selesai'], 2),
                'total_nilai' => 'Rp' . number_format($data['total_nilai']),
                'total_upah' => 'Rp' . number_format($data['total_upah']),
                'persent_sharing' => "Sharing Pendapatkan $getShating%",
                'total_sharing' => 'Rp' . number_format(($percent * $data['total_nilai'])),
            ];

            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {

            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function grafikPendapatan()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            $tahun = $this->request->getPost('filterTahun')['tahun'] ?? $this->_tahun;

            // data cabang
            $dataCabang = $this->db->table('cabang')->select('id_cabang, nama_cabang')
                ->whereIn('id_cabang', $id_cabang)
                ->orderBy('nama_cabang', 'ASC')
                ->get()->getResultArray();

            // periode bulan
            $periode = $this->_periode($tahun);

            $data = [];
            foreach ($dataCabang as $k => $cab) {
                $data[$k] = [
                    'name' => $cab['nama_cabang'],
                ];

                // loping data sesuai dengan bulan
                foreach ($periode as $key => $bulan) {
                    $dataClosingUnit = $this->db->table('closing c')
                        ->select('c.id_closing, c.periode_closing, c.cabang_id, u.nomor_spp, u.jumlah_diskon')
                        ->join('closing_detail cd', 'cd.closing_id = c.id_closing')
                        ->join('unit u', 'u.id_unit = cd.unit_id')
                        ->where('c.periode_closing', $bulan)
                        ->where('c.cabang_id', $cab['id_cabang'])
                        ->get()->getResultArray();

                    $total = 0;
                    foreach ($dataClosingUnit as $unit) {
                        $total += $unit['jumlah_diskon'] ?? 0;
                    }

                    $data[$k]['data'][] = $total ?? 0;
                }
            }

            // looping bulan untuk kebutuhan grafik
            $per = [];
            foreach ($periode as $key => $bulan) {
                $per[] = substr($bulan, 0, 3);
            }

            $data = [
                'title' => 'GRAFIK CLOSINGAN PER BULAN CABANG TAHUN ' . $tahun,
                'data' => $data,
                'periode' => $per,
                'tahun' => $tahun
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
            $tahun = $this->request->getPost('filterTahun')['tahun'] ?? $this->_tahun;

            // periode bulan
            $periode = $this->_periode($tahun);

            $data = [];
            // loping data sesuai dengan bulan
            foreach ($periode as $key => $bulan) {
                $dataClosingUnit = $this->db->table('closing c')
                    ->select('c.id_closing, c.periode_closing, c.cabang_id, u.nomor_spp, u.jumlah_diskon')
                    ->join('closing_detail cd', 'cd.closing_id = c.id_closing')
                    ->join('unit u', 'u.id_unit = cd.unit_id')
                    ->where('c.periode_closing', $bulan)
                    ->whereIn('c.cabang_id', $id_cabang)
                    ->get()->getResultArray();

                $total = 0;
                foreach ($dataClosingUnit as $unit) {
                    $total += $unit['jumlah_diskon'] ?? 0;
                }

                $data[] = $total ?? 0;
            }

            // looping bulan untuk kebutuhan grafik
            $per = [];
            foreach ($periode as $key => $bulan) {
                $per[] = substr($bulan, 0, 3);
            }

            $data = [
                'title' => 'GRAFIK CLOSINGAN PER BULAN TAHUN ' . $tahun,
                'data' => $data,
                'periode' => $per,
                'tahun' => $tahun,
                'test' => $periode
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
            // agar tidak menghitung unit yang closing
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->getCompiledSelect();

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
                $dataUnit->where("u.id_unit NOT IN ($subQuery)");
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
                'data' => $persentaseData,
            ];

            return ResponseJSONCollection::success($data, 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {

            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function summaryPemakaianBahan()
    {
        try {
            $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
            // agar tidak menghitung unit yang closing
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->getCompiledSelect();

            $dataJenis = $this->db->table('jenis')->get()->getResultArray();

            $data = [];
            $total = 0;
            foreach ($dataJenis as $row) {
                // Jumlakan data jenis / penggunaan material
                $dataUnit = $this->db->table('unit_material');
                $dataUnit->select('material.jenis_id, unit_material.material_id, unit_material.harga, unit_material.jumlah, unit_material.unit_id, unit.cabang_id');
                $dataUnit->join('unit', 'unit.id_unit = unit_material.unit_id');
                $dataUnit->join('material', 'material.id_material = unit_material.material_id');
                $dataUnit->whereIn('unit.cabang_id', $id_cabang);
                $dataUnit->where("unit.id_unit NOT IN ($subQuery)");
                $pemakaianMaterial = $dataUnit->where('material.jenis_id', $row['id_jenis'])->get()->getResultArray();

                // jumlahkan
                $total_pemakaian = 0;
                foreach ($pemakaianMaterial as $pemakaian) {
                    $total_pemakaian += ($pemakaian['harga'] * $pemakaian['jumlah']);
                }

                $data['data'][$row['id_jenis']]['nama'] = $row['nama_jenis'];
                $data['data'][$row['id_jenis']]['total'] = $total_pemakaian;
            }

            $html = view('side_dashboard_material', $data);

            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Data berhasil diambil', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {

            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Keslahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
}
