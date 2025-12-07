<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ExcelKasbonLibrary;
use App\Libraries\ResponseJSONCollection;
use App\Models\KasbonModel;
use CodeIgniter\HTTP\ResponseInterface;

class KasbonController extends BaseController
{
    private $title = 'Kasbon';
    private $modelKasbon;

    public function __construct()
    {
        $this->modelKasbon = new KasbonModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/kasbon/index', $data);
    }

    public function detail($id_karyawan)
    {
        $data = [
            'title' => $this->title,
            'karyawan' => $this->modelKasbon->db->table('karyawan')->where('id_karyawan', $id_karyawan)->get()->getRowArray(),
            'kasbon' => array_reverse($this->modelKasbon->dataKasbonKaryawan($id_karyawan))
        ];

        return view('pages/kasbon/detail', $data);
    }

    public function pengajuanSave(int $id_karyawan)
    {
        $data = $this->request->getPost(); // mengambil post data
        $data['karyawan_id'] = $id_karyawan;
        $data['status'] = 'pengajuan';

        try {
            $save = $this->modelKasbon->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelKasbon->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pengajuanDataAll()
    {
        try {
            $data['hide_karyawan'] = 1;
            $data['pengajuan'] = $this->modelKasbon->getHistoriPengajuan();
            $html = view('pages/kasbon/pengajuan_side', $data);

            return ResponseJSONCollection::success(['html' => $html], 'Success.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pengajuanData($id_karyawan = '')
    {
        try {
            $data['hide_karyawan'] = 0;
            $data['pengajuan'] = $this->modelKasbon->getHistoriPengajuan($id_karyawan);
            $html = view('pages/kasbon/pengajuan_side', $data);

            return ResponseJSONCollection::success(['html' => $html], 'Success.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function persetujuan()
    {
        $data = [
            'title' => $this->title,
            'pengajuan' => $this->modelKasbon->getPengajuan()
        ];

        return view('pages/kasbon/persetujuan', $data);
    }

    public function persetujuanSave()
    {
        $data = $this->request->getPost(); // mengambil post data

        $saveData = [];
        foreach ($data['kasbon'] as $key => $value) {
            $saveData[$key] = [
                'id_kasbon' => $value,
                'status' => $data['status'] == 1 ? 'terima' : 'tolak'
            ];

            if ($data['status'] == 1) $saveData[$key]['disetujui'] = str_replace(['Rp', ',', '.', ' '], '', $data['disetujui'][$key]);
        }

        try {
            $update = $this->modelKasbon->updateBatch($saveData, 'id_kasbon'); // update data

            return ResponseJSONCollection::success([$saveData], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pengajuanImport()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/kasbon/import_kasbon', $data);
    }

    public function exportTemplate()
    {
        $data = $this->modelKasbon->getKaryawan();

        $lib = new ExcelKasbonLibrary;
        return $lib->export($data, "Import Kasbon Karyawan.xlsx");
    }

    public function loadImport(int $id = 0)
    {
        $file = $this->request->getFile('file_excel');
        if (!$file || !$file->isValid()) {
            return ResponseJSONCollection::error([], 'File tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        try {
            $tmpPath = $file->getTempName();
            $excel = new ExcelKasbonLibrary;
            $rows = $excel->toArrayFromFile($id, $tmpPath, 0);

            $html = view('pages/kasbon/import_load', ['pengajuan' => $rows]);

            return ResponseJSONCollection::success(['html' => $html], 'Success.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Import Data gagal.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function saveImport()
    {
        $postData = $this->request->getPost();

        $data = [];
        foreach ($postData['karyawan_id'] as $key => $row) {
            $data[] = [
                'karyawan_id' => $row,
                'tanggal' => date('Y-m-d'),
                'alasan' => $postData['alasan'][$key],
                'jumlah' => $postData['jumlah'][$key],
                'jenis' => 'pinjam',
                'status' => 'pengajuan',
            ];
        }

        try {
            $this->modelKasbon->insertBatch($data);
            return ResponseJSONCollection::success([], 'Data berhasil diimport.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pembayaranKasbon()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/kasbon/pembayaran', $data);
    }

    public function loadPembayaranKasbon()
    {
        $dataPost = $this->request->getPost();
        $cabangId = $dataPost['cabang_id'];
        $komponenId = $dataPost['komponen_id'];
        $gajiId = $dataPost['periode'];

        try {
            $data = $this->modelKasbon->getDataPembayaran($cabangId, $komponenId, $gajiId);
            $html = view('pages/kasbon/pembayaran_load', ['data' => $data]);

            return ResponseJSONCollection::success(['html' => $html], 'Data berhasil diload.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function savePembayaranKasbon()
    {
        $postData = $this->request->getPost();

        $data = [];
        foreach ($postData['id_karyawan'] as $key => $row) {
            $data[] = [
                'karyawan_id' => $row,
                'tanggal' => date('Y-m-d'),
                'jumlah' => $postData['jumlah'][$key],
                'jenis' => 'bayar',
                'status' => 'pengajuan',
                'alasan' => 'Pembayaran melalui potongan Gaji',
            ];
        }

        try {
            $this->modelKasbon->insertBatch($data);
            return ResponseJSONCollection::success([], 'Data berhasil diimport.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
