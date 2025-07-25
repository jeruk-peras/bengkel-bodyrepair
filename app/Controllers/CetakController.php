<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
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

    public function pemakaianBahan()
    {
        $data = [
            'title' => $this->title . ' Pemakaian Bahan',
        ];
        return view('pages/cetak/cetak_pemakaian_bahan', $data);
    }
}
