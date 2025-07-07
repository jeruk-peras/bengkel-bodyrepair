<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\CabangModel;
use CodeIgniter\HTTP\ResponseInterface;

class CabangController extends BaseController
{
    private $title = 'Cabang';
    private $modelCabang;

    public function __construct()
    {
        $this->modelCabang = new CabangModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/cabang/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'nama_cabang'     => $data['nama_cabang'],
            'lokasi_cabang'   => $data['lokasi_cabang'],
            'alamat_lengkap'  => $data['alamat_lengkap'],
        ];
        
        try {
            $save = $this->modelCabang->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelCabang->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(int $id)
    {
        try {
            $data = $this->modelCabang->find($id); // mengambil data
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
            'nama_cabang'     => $data['nama_cabang'],
            'lokasi_cabang'   => $data['lokasi_cabang'],
            'alamat_lengkap'    => $data['alamat_lengkap'],
        ];

        try {
            $update = $this->modelCabang->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelCabang->errors(); // mengambil data error
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
            $this->modelCabang->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
