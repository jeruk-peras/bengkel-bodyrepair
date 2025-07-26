<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\JenisModel;
use App\Models\UnitMaterialModel;
use CodeIgniter\HTTP\ResponseInterface;

class CetakController extends BaseController
{
    private $title = 'Cetak';

    public function __construct() {}

    public function epoxy()
    {
        $data = [
            'title' => $this->title . ' Epoxy',
        ];
        return view('pages/cetak/cetak_epoxy', $data);
    }

    public function addEpoxy()
    {
        $data = [
            'title' => $this->title . ' Tambah Epoxy',
        ];
        return view('pages/cetak/add_cetak_epoxy', $data);
    }

    public function saveEpoxy()
    {
        $id_unit = $this->request->getPost('id_unit');

        try {
            $save = $this->db->table('cetak')->insert([
                'unit_id' => $id_unit,
                'kategori_cetak' => 'epoxy',
                'cabang_id' => $this->id_cabang,
            ]);

            $id_cetak = $this->db->insertID();

            if ($save) return ResponseJSONCollection::success(['redirect' => base_url('cetak/epoxy/' . $id_cetak . '/detail')], 'Data berhasil disimpan', ResponseInterface::HTTP_OK);

            return ResponseJSONCollection::error([], 'Gagal menyimpan data', ResponseInterface::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Gagal menyimpan data', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function detailEpoxy(int $id)
    {
        // cek apakah kategori cetak adalah epoxy
        $cetak = $this->db->table('cetak')->select('kategori_cetak')->where('id_cetak', $id)->get()->getRowArray();
        if (!$cetak || $cetak['kategori_cetak'] !== 'epoxy') {
            return redirect()->to(base_url('cetak/epoxy'));
        }

        $data = [
            'title' => $this->title . ' Detail Epoxy',
        ];

        // load data tabel cetak join unit
        $cetak = $this->db->table('cetak')
            ->select('cetak.*, unit.nomor_polisi, unit.nomor_spp, unit.model_unit, asuransi.nama_asuransi')
            ->join('unit', 'unit.id_unit = cetak.unit_id')
            ->join('asuransi', 'asuransi.id_asuransi = unit.asuransi_id', 'left')
            ->where('cetak.id_cetak', $id)
            ->get()->getRowArray();

        $data['cetak'] = $cetak;

        return view('pages/cetak/detail_cetak_epoxy', $data);
    }

    public function gandeng()
    {
        $data = [
            'title' => $this->title . ' Gandeng',
        ];
        return view('pages/cetak/cetak_gandeng', $data);
    }

    public function addGandeng()
    {
        $data = [
            'title' => $this->title . ' Tambah Gandeng',
        ];
        return view('pages/cetak/add_cetak_gandeng', $data);
    }

    public function saveGandeng()
    {
        $id_unit = $this->request->getPost('id_unit');

        try {
            $save = $this->db->table('cetak')->insert([
                'unit_id' => $id_unit,
                'kategori_cetak' => 'gandeng',
                'cabang_id' => $this->id_cabang,
            ]);

            $id_cetak = $this->db->insertID();

            if ($save) return ResponseJSONCollection::success(['redirect' => base_url('cetak/gandeng/' . $id_cetak . '/detail')], 'Data berhasil disimpan', ResponseInterface::HTTP_OK);

            return ResponseJSONCollection::error([], 'Gagal menyimpan data', ResponseInterface::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Gagal menyimpan data', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function detailGandeng(int $id)
    {

        // cek apakah kategori cetak adalah gandeng
        $cetak = $this->db->table('cetak')->select('kategori_cetak')->where('id_cetak', $id)->get()->getRowArray();
        if (!$cetak || $cetak['kategori_cetak'] !== 'gandeng') {
            return redirect()->to(base_url('cetak/gandeng'));
        }
        $data = [
            'title' => $this->title . ' Detail Gandeng',
        ];

        // load data tabel cetak join unit
        $cetak = $this->db->table('cetak')
            ->select('cetak.*, unit.nomor_polisi, unit.nomor_spp, unit.model_unit, asuransi.nama_asuransi')
            ->join('unit', 'unit.id_unit = cetak.unit_id')
            ->join('asuransi', 'asuransi.id_asuransi = unit.asuransi_id', 'left')
            ->where('cetak.id_cetak', $id)
            ->get()->getRowArray();

        $data['cetak'] = $cetak;

        return view('pages/cetak/detail_cetak_gandeng', $data);
    }

    public function uploadFoto()
    {
        $dataPost = $this->request->getPost();
        $gambarStatus = $this->request->getFile('gambar');

        // validasi gambar
        $setRules = [
            'gambar' => [
                'rules'  => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

        $this->validator->setRules($setRules);
        $isValid = $this->validator->run($dataPost);

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return ResponseJSONCollection::error($errors, 'Validasi gagal', ResponseInterface::HTTP_BAD_REQUEST);
        }
        // end validasi gambar

        // upload gambar
        $path = './assets/images/epoxy/';
        if ($gambarStatus) $fileName = UploadFileLibrary::uploadImage($gambarStatus, $path);

        $data = [
            'cetak_id'   => $dataPost['id_cetak'],
            'gambar'   => $fileName,
        ];

        try {
            $save = $this->db->table('cetak_gambar')->insert($data);

            if (!$save) {
                return ResponseJSONCollection::error(['Gagal menyimpan data gambar'], 'Gagal menyimpan data gambar', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Foto berhasil diupload.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id)
    {
        try {
            // Hapus file gambar dari server
            $gambar = $this->db->table('cetak_gambar')->select('gambar')->where('cetak_id', $id)->get()->getResultArray();
            foreach ($gambar as $g) {
                if (file_exists('./assets/images/epoxy/' . $g['gambar'])) {
                    unlink('./assets/images/epoxy/' . $g['gambar']);
                }
            }
            $delete = $this->db->table('cetak')->delete(['id_cetak' => $id]);

            if ($delete) {
                return ResponseJSONCollection::success([], 'Data berhasil dihapus', ResponseInterface::HTTP_OK);
            }

            return ResponseJSONCollection::error(['Gagal menghapus data'], 'Gagal menghapus data', ResponseInterface::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listUnit()
    {
        $data = [
            'title' => $this->title . ' Pemakaian Bahan',
        ];
        return view('pages/cetak/pemakaian_bahan', $data);
    }

    public function pemakaianBahan(int $id)
    {
        $data = [
            'title' => $this->title . ' Pemakaian Bahan',
        ];

        $unit = $this->db->table('unit')->where('id_unit', $id)->get()->getRowArray();

        $data['data'] = $unit;
        return view('pages/cetak/cetak_pemakaian_bahan', $data);
    }

    public function pemakaianBahanDetail(int $id)
    {
        $modelMaterial = new UnitMaterialModel();
        try {
            $html = '';

            // get data jenis material yang digunakan, jadi tidak semua jenis akan didpatkan
            $dataJenis =  $this->db->table('unit_material')
                ->select('jenis.*')
                ->join('material', 'material.id_material = unit_material.material_id', 'left')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
                ->where('unit_material.unit_id', $id)->orderBy('jenis.nama_jenis', 'ASC')
                ->groupBy('jenis.nama_jenis')->get()->getResultArray();

            foreach ($dataJenis as $jenis) {
                $html .= '
                <tr style="background-color: darkgrey;">
                    <th  colspan="5" >' . strtoupper($jenis['nama_jenis']) . '</th>
                </tr>
                <tr>
                    <th>Nama Material</th>
                    <th>Harga</th>
                    <th>jml</th>
                    <th>Total Harga</th>
                    <th>Mekanik</th>
                </tr>';

                // get data material sesuai dengan jenisnya
                $dataMaterial = $modelMaterial
                    ->select('unit_material.*, material.nama_material, material.merek, material.harga, material.stok, satuan.nama_satuan, mekanik.nama_mekanik')
                    ->join('mekanik', 'mekanik.id_mekanik = unit_material.mekanik_id', 'left')
                    ->join('material', 'material.id_material = unit_material.material_id', 'left')
                    ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
                    ->where('unit_material.unit_id', $id)->where('material.jenis_id', $jenis['id_jenis'])
                    ->orderBy('unit_material.tanggal', 'DESC')
                    ->findAll();

                $total_harga = 0;
                $total_jumlah = 0;
                foreach ($dataMaterial as $row) {
                    $html .=
                        '<tr>
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
                    <th colspan="2" class="text-end">Total&nbsp;</th>
                    <th class="text-center">' . $total_jumlah . '</th>
                    <th class="text-end">Rp' . number_format($total_harga) . '</th>
                    <th></th>
                </tr>';
            }



            // $i = 1;
            // foreach ($data as $row) {
            //     $html .=
            //         '<tr>
            //             <td>' . $i++ . '</td>
            //             <td>' . $row['nama_jenis'] . '</td>
            //             <td>' . $row['nama_material'] . '</td>
            //             <td>Rp' . $row['harga'] . '</td>
            //             <td>' . $row['jumlah'] . '</td>
            //             <td>' . $row['nama_satuan'] . '</td>
            //             <td>Rp' . $row['total_harga'] . '</td>
            //             <td>' . $row['tanggal'] . '</td>
            //             <td><a href="/material-keluar/' . $row['id_unit_material'] . '/delete" class="btn btn-danger btn-sm btn-del"><i class="bx bx-trash me-0"></i></a></td>
            //         </tr>';
            // }


            return ResponseJSONCollection::success(['html' => $html, 'data' => $dataMaterial], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
}
