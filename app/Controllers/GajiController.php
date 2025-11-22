<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Controllers\BaseController;
use App\Libraries\ExcelGajiLibrary;
use App\Libraries\ResponseJSONCollection;
use App\Models\GajiModel;
use App\Models\KaryawanModel;
use App\Models\KomponenGajiModel;
use CodeIgniter\HTTP\ResponseInterface;

class GajiController extends BaseController
{
    private $title = 'Gaji Karyawan';
    private $modelGaji;

    public function __construct()
    {
        $this->modelGaji = new GajiModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/gaji/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        try {
            $save = $this->modelGaji->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelGaji->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }
            $id_gaji = $this->modelGaji->insertID();
            $r = $this->modelGaji->saveDetailGaji($id_gaji);

            return ResponseJSONCollection::success([$r], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(int $id)
    {
        try {
            $data = $this->modelGaji->find($id); // mengambil data
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

        try {
            $update = $this->modelGaji->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelGaji->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->modelGaji->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function detail(int $id)
    {
        $data = [
            'title' => $this->title,
            ...$this->modelGaji->detailGaji($id)
        ];

        $data['detailgaji'] = $this->modelGaji->find($id);

        return view('pages/gaji/detail', $data);
    }

    public function sideDetailGaji(int $id)
    {
        try {
            $data = [
                'id_gaji' => $id,
                ...$this->modelGaji->detailGaji($id)
            ];
            $html = view('pages/gaji/detail_side', $data);
            return ResponseJSONCollection::success(['html' => $html], 'Fetch Data berhasil.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Error', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function export(int $id)
    {
        $data = $this->modelGaji->detailGaji($id);
        $periode = $this->modelGaji->find($id)['periode'];

        $lib = new ExcelGajiLibrary;
        $data['periode'] = $periode;
        return $lib->export($data, "Export Gaji Karyawan $periode.xlsx");
    }

    public function import(int $id)
    {
        $file = $this->request->getFile('file_excel');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        // cek jika data di lock
        $rowData = $this->modelGaji->find($id);
        if ($rowData['status'] = 1) redirect()->to("/gaji-karyawan/$id/detail");

        $tmpPath = $file->getTempName();
        $excel = new ExcelGajiLibrary;
        $rows = $excel->toArrayFromFile($id, $tmpPath, 0);

        $key = ['gaji_id', 'karyawan_id', 'komponen_gaji_id'];
        $this->modelGaji->db->table('gaji_detail')->updateBatch($rows, $key);

        return redirect()->to("/gaji-karyawan/$id/detail");
    }

    public function printgaji(int $id, $id_karyawan = '')
    {
        $data = [
            'gaji' => $this->modelGaji->detailGaji($id, $id_karyawan)
        ];

        return view('pages/gaji/print', $data);
    }

    public function lockData($id_gaji)
    {
        try {
            // cek password Finance
            $where = [
                'id_user' => session()->get('user_id'),
                'role' => 'Finance',
            ];
            $user_admin = $this->db->table('users')->where($where)->get()->getRowArray();

            $password = $this->request->getPost('password');

            // Jika tidak  data ditemukan
            if (!$user_admin || !password_verify($password, $user_admin['password'])) {
                return ResponseJSONCollection::error(['password' => 'Password salah, silahkan ulangi.'], 'Maaf password salah.', ResponseInterface::HTTP_UNAUTHORIZED);
            }

            // get data
            $data = $this->modelGaji->find($id_gaji);

            // cek status closing
            if ($data['status'] == 0) {
                // ubah status ke lock
                $this->modelGaji->update($id_gaji, ['status' => 1]);
            } else {
                // ubah status ke lock
                $this->modelGaji->update($id_gaji, ['status' => 0]);
            }
            return ResponseJSONCollection::success([$data], 'Berhasil Dilock', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function slipGaji()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/cetak/slip_gaji', $data);
    }
}
