<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\ClosingModel;
use App\Models\UnitMaterialModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

use function PHPUnit\Framework\returnSelf;

class LaporanController extends BaseController
{
    private $title = 'Laporan';
    private $modelClosing;

    public function __construct()
    {
        $this->modelClosing = new ClosingModel();
    }

    public function closing()
    {
        $data = [
            'title' => $this->title . ' - Closingan',
        ];

        return view('pages/closing/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => $this->title . ' - Closingan',
        ];

        return view('pages/closing/add', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'tanggal'           => $data['tanggal'],
            'periode_closing'   => $data['periode_closing'],
            'catatan'           => $data['catatan'],
            'cabang_id'         => $this->id_cabang,
        ];

        try {
            // validasi jika sudah melakukan closing di periode tersebut
            $valid = $this->modelClosing->where('periode_closing', $data['periode_closing'])
                ->where('cabang_id', $data['cabang_id'])
                ->countAllResults();
            if ($valid > 0) return ResponseJSONCollection::error(['periode_closing' => 'Periode closing sudah digunakan sebelumnya'], 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);

            $save = $this->modelClosing->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelClosing->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            };

            $id = $this->modelClosing->getInsertID();

            return ResponseJSONCollection::success(['redirect' => "/closing/$id/detail"], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(int $id)
    {
        try {
            $data = $this->modelClosing->find($id); // mengambil data
            // jika data tidak ditemukan
            if (!$data) {
                return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success($data, 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id)
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'tanggal'           => $data['tanggal'],
            'periode_closing'   => $data['periode_closing'],
            'catatan'           => $data['catatan'],
            'cabang_id'         => $this->id_cabang,
        ];

        try {

            $update = $this->modelClosing->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelClosing->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error(['periode_closing' => 'Periode closing sudah digunakan sebelumnya.', 'error_mess' => $e->getMessage()], 'Periode closing sudah digunakan sebelumnya.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id)
    {
        try {
            if ($this->modelClosing->find($id)['status'] == 1) return ResponseJSONCollection::error([], 'Data unit sudah di lock.', ResponseInterface::HTTP_BAD_REQUEST);

            $this->modelClosing->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function detail(int $id)
    {
        $data = [
            'title' => $this->title . ' - Closingan',
            'data' => $this->db->table('closing')->where('id_closing', $id)->get()->getRowArray()
        ];

        return view('pages/closing/detail', $data);
    }

    public function addUnit()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'closing_id'        => $data['closing_id'],
            'unit_id'   => $data['unit_id'],
        ];

        try {
            $save = $this->db->table('closing_detail')->insert($data); // save data

            return ResponseJSONCollection::success([$save], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUnit(int $id)
    {
        try {
            $delete = $this->db->table('closing_detail')->where('id_closing_detail', $id)->delete(); // delete data
            return ResponseJSONCollection::success([$delete], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function saveKolektifUnit()
    {
        $postData = $this->request->getPost();
        try {
            $data = [];

            foreach ($postData['unit_id'] as $row) {
                $data[] = [
                    'closing_id' => $postData['closing_id'],
                    'unit_id' => $row
                ];
            }
            $save = $this->db->table('closing_detail')->insertBatch($data);
            return ResponseJSONCollection::success($data, 'Data berhasil Simapan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function summaryClosing(int $id)
    {
        try {
            $data = [
                'total_panel' => 0,
                'pemakaian_bahan' => 0,
                'total_pendapatan' => 0
            ];

            $subQuery = $this->db->table('closing_detail')->select('unit_id')->where('closing_id', $id)->getCompiledSelect();

            $dataDetailClosing = $this->db->table('unit')
                ->select('unit.*, cabang.nama_cabang')
                ->join('cabang', 'cabang.id_cabang = unit.cabang_id', 'left')
                ->where("id_unit IN ($subQuery)")
                ->get()->getResultArray();

            // loop untuk perhitungan total panel dan total pendapatan
            foreach ($dataDetailClosing as $row) {
                $data['total_panel'] += $row['jumlah_panel'];
                $data['total_pendapatan'] += $row['jumlah_diskon'];

                // loop pemakaian bahan
                $materialUnit = $this->db->table('unit_material')
                    ->join('material', 'material.id_material = unit_material.material_id', 'left')
                    ->where("unit_material.unit_id", $row['id_unit'])
                    ->get()->getResultArray();

                foreach ($materialUnit as $mu) {
                    $data['pemakaian_bahan'] += $mu['total_harga'];
                }
            }

            $data['total_panel'] = number_format($data['total_panel'], 2);
            $data['pemakaian_bahan'] = 'Rp' . number_format($data['pemakaian_bahan'], 0, '', '.');
            $data['total_pendapatan'] = 'Rp' . number_format($data['total_pendapatan'], 0, '', '.');

            return ResponseJSONCollection::success($data, 'Summary Data Closing', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function pemakaianBahanDetail(int $id_closing)
    {
        $modelMaterial = new UnitMaterialModel();
        try {
            $html = '';

            $subQuery = $this->db->table('closing_detail')->select('unit_id')->where('closing_id', $id_closing)->getCompiledSelect();
            // get data jenis material yang digunakan, jadi tidak semua jenis akan didpatkan
            $dataJenis =  $this->db->table('unit_material')
                ->select('jenis.*')
                ->join('material', 'material.id_material = unit_material.material_id', 'left')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
                ->where("unit_material.unit_id IN ($subQuery)")
                ->orderBy('jenis.nama_jenis', 'ASC')->groupBy('jenis.nama_jenis')->get()->getResultArray();

            foreach ($dataJenis as $jenis) {
                $html .= '
                <tr style="background-color: darkgrey;">
                    <th  colspan="7" >' . strtoupper($jenis['nama_jenis']) . '</th>
                </tr>
                <tr>
                    <th>Nomor SPP</th>
                    <th>Nomor POL</th>
                    <th>Nama Material</th>
                    <th>Harga</th>
                    <th>jml</th>
                    <th>Total Harga</th>
                    <th>Mekanik</th>
                </tr>';

                // get data material sesuai dengan jenisnya
                $dataMaterial = $modelMaterial
                    ->select('unit_material.*, unit.nomor_spp, unit.nomor_polisi, material.nama_material, material.merek, material.harga, satuan.nama_satuan, mekanik.nama_mekanik')
                    ->join('unit', 'unit.id_unit = unit_material.unit_id', 'left')
                    ->join('mekanik', 'mekanik.id_mekanik = unit_material.mekanik_id', 'left')
                    ->join('material', 'material.id_material = unit_material.material_id', 'left')
                    ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
                    ->where("unit_material.unit_id IN ($subQuery)")
                    ->where('material.jenis_id', $jenis['id_jenis'])->orderBy('unit_material.tanggal', 'DESC')
                    ->findAll();



                $total_harga = 0;
                $total_jumlah = 0;
                foreach ($dataMaterial as $row) {
                    $html .=
                        '<tr>
                            <td class="text-center">' . $row['nomor_spp'] . '</td>
                            <td class="text-center">' . $row['nomor_polisi'] . '</td>
                            <td>' . $row['nama_material'] . '</td>
                            <td class="text-end">Rp' . number_format($row['harga']) . '</td>
                            <td class="text-center">' . $row['jumlah'] . '</td>
                            <td class="text-end">Rp' . number_format($row['total_harga']) . '</td>
                            <td>' . $row['nama_mekanik'] . '</td>
                        </tr>';

                    $total_harga += $row['total_harga'];
                    $total_jumlah += $row['jumlah'];
                }

                $html .= '
                 <tr>
                    <th colspan="4" class="text-end">Total&nbsp;</th>
                    <th class="text-center">' . $total_jumlah . '</th>
                    <th class="text-end">Rp' . number_format($total_harga) . '</th>
                    <th></th>
                </tr>';
            }

            return ResponseJSONCollection::success(['html' => $html,], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function closingMekanik(int $id_closing)
    {
        try {
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->where('closing_id', $id_closing)->getCompiledSelect();

            $statusData = $this->db->table('unit_status_harga ush')
                ->select('ush.*')
                ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
                ->where("id_unit IN ($subQuery)")
                ->groupBy('ush.nama_status')
                ->orderBy('ush.urutan', 'ASC')
                ->get()->getResultArray();

            // total harga status
            $hargaStatusTotal = [];
            foreach ($statusData as $row) {
                $hargaStatusTotal[$row['nama_status']] = 0;
            }

            // total pane;
            $totalPanel = [];
            foreach ($statusData as $row) {
                $totalPanel[$row['nama_status']] = 0;
            }

            // data unit    
            $unitStatus = $this->db->table('unit')
                ->select('unit.*, cabang.nama_cabang')
                ->join('cabang', 'cabang.id_cabang = unit.cabang_id', 'left')
                ->where("id_unit IN ($subQuery)")
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

                        ($totalPanel[$statusUnit['nama_status']] += $u['jumlah_panel']);

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
                    'harga_spp' => $u['harga_spp'],
                    'diskon' => $u['diskon'],
                    'jumlah_diskon' => $u['jumlah_diskon'],
                    'total_upah_mekanik' => $u['total_upah_mekanik'],
                    'jumlah_panel' => $u['jumlah_panel'],
                    'status' => $unitStatus
                ];
            }

            $data = [
                'periode' => $this->db->table('closing')->where('id_closing', $id_closing)->get()->getRowArray()['periode_closing'],
                'status' => $statusData,
                'units' => $units,
                'harga_status_total' => $hargaStatusTotal,
                'panel_total' => $totalPanel
            ];

            return ResponseJSONCollection::success(['html' => view('pages/laporan/side_closingan_mekanik', $data,), $data], 'Data ditemukan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function closingan(int $id_closing)
    {
        try {
            $subQuery = $this->db->table('closing_detail')->select('unit_id')->where('closing_id', $id_closing)->getCompiledSelect();

            $dataPersentase = $this->db->table('closing')
                ->join('setting_biaya', 'setting_biaya.cabang_id = closing.cabang_id', '')
                ->where('closing.id_closing', $id_closing)
                ->get()->getRowArray();

            // spp
            $HargaSPP = [
                'total_harga_spp' => 0,
                'total_harga_spp_diskon' => 0,
                'total_panel' => 0,
                'total_upah_mekanik' => 0,
            ];

            // tatal pemakaian material
            $jenis = $this->db->table('jenis')->orderBy('nama_jenis', 'ASC')->get()->getResultArray();
            $dataPemakaianMaterial = [];
            foreach ($jenis as $j) {

                // menghitung total pemakaian material
                $unitMaterial = $this->db->table('unit_material um')
                    ->select('um.material_id, um.harga, um.jumlah, u.cabang_id, m.jenis_id, u.tanggal_masuk')
                    ->join('unit u', 'u.id_unit = um.unit_id')
                    ->join('material m', 'm.id_material = um.material_id')
                    ->where('m.jenis_id', $j['id_jenis'])
                    ->where("id_unit IN ($subQuery)")
                    ->get()->getResultArray();

                $totalPamakaian = 0;
                foreach ($unitMaterial as $um) {
                    $totalPamakaian += ($um['harga'] * $um['jumlah']); // menjumlahkan pemakaian
                }

                // array total pemakaian
                $dataPemakaianMaterial[] = [
                    'nama_jenis' => $j['nama_jenis'],
                    'total' => $totalPamakaian
                ];
            }

            //===============================================
            // total upah mekanik
            $statusData = $this->db->table('unit_status_harga ush')
                ->select('ush.*')
                ->join('unit u', 'u.id_unit = ush.unit_id', 'LEFT')
                ->where("id_unit IN ($subQuery)")
                ->groupBy('ush.nama_status')
                ->orderBy('ush.urutan', 'ASC')
                ->get()->getResultArray();

            // total harga status
            $hargaStatusTotal = [];
            foreach ($statusData as $row) {
                $hargaStatusTotal[$row['nama_status']] = 0;
            }

            // total pane;
            $totalPanel = [];
            foreach ($statusData as $row) {
                $totalPanel[$row['nama_status']] = 0;
            }
            // ==================================================

            // data unit    
            $unit = $this->db->table('unit')
                ->select('unit.*, cabang.nama_cabang')
                ->join('cabang', 'cabang.id_cabang = unit.cabang_id', 'left')
                ->where("id_unit IN ($subQuery)")
                ->get()->getResultArray();

            foreach ($unit as $u) {
                // spp
                $HargaSPP['total_harga_spp'] += $u['harga_spp'];
                $HargaSPP['total_harga_spp_diskon'] += $u['jumlah_diskon'];
                $HargaSPP['total_panel'] += $u['jumlah_panel'];
                $HargaSPP['total_upah_mekanik'] += $u['total_upah_mekanik'];

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

                        ($totalPanel[$statusUnit['nama_status']] += $u['jumlah_panel']);

                        $unitStatus[] = [
                            'nama_status' => $row['nama_status'],
                            'harga_status' => $statusUnit['harga_status'],
                            'total_harga_status' => $hargaStatusTotal[$statusUnit['nama_status']],
                            'total_panel_status' => $totalPanel[$statusUnit['nama_status']]
                        ];
                    } else {
                        
                        // jika status belum di set di unit
                        $unitStatus[] = [
                            'nama_status' => $row['nama_status'],
                            'harga_status' => $row['harga_status'],
                            'total_harga_status' => $hargaStatusTotal[$row['nama_status']],
                            'total_panel_status' => $totalPanel[$row['nama_status']]
                        ];
                    }
                }
            }

            $data = [
                'periode' => $dataPersentase['periode_closing'],
                'spp' => $HargaSPP,
                'material' => $dataPemakaianMaterial,
                'mekanik' => $unitStatus ?? [],
                'diskon_percent' => $dataPersentase['diskon'],
                'sharing_percent' => $dataPersentase['sharing'],
                'percent_diskon' => $dataPersentase['diskon'] / 100,
                'percent_sharing' => $dataPersentase['sharing'] / 100,
            ];

            // $html = '';
            $html = view('pages/laporan/side_closingan', $data);

            return ResponseJSONCollection::success(['html' => $html, $data], 'Data ditemukan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi Kesalahan Server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function lockData(int $id_closing)
    {
        try {
            // cek password super admin
            $where = [
                'id_user' => session()->get('user_id'),
                'role' => 'Super Admin',
            ];
            $user_admin = $this->db->table('users')->where($where)->get()->getRowArray();

            $password = $this->request->getPost('password');

            // Jika tidak  data ditemukan
            if (!$user_admin || !password_verify($password, $user_admin['password'])) {
                return ResponseJSONCollection::error(['password' => 'Password salah, silahkan ulangi.'], 'Maaf password salah.', ResponseInterface::HTTP_UNAUTHORIZED);
            }

            // get data closing
            $data = $this->modelClosing->find($id_closing);

            // cek status closing
            if ($data['status'] == 0) {
                // ubah status ke lock
                $this->modelClosing->update($id_closing, ['status' => 1]);
            } else {
                // ubah status ke lock
                $this->modelClosing->update($id_closing, ['status' => 0]);
            }
            return ResponseJSONCollection::success([$data], 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
