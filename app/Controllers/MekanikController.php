<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\MekanikModel;
use CodeIgniter\HTTP\ResponseInterface;

class MekanikController extends BaseController
{
    private $title = 'Mekanik';
    private $modelMekanik;

    public function __construct()
    {
        $this->modelMekanik = new MekanikModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/mekanik/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'nama_mekanik'     => $data['nama_mekanik'],
            'no_handphone'   => $data['no_handphone'],
            'cabang_id'     => $this->id_cabang
        ];
        
        try {
            $save = $this->modelMekanik->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelMekanik->errors(); // mengambil data error
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
            $data = $this->modelMekanik->find($id); // mengambil data
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
            'nama_mekanik'     => $data['nama_mekanik'],
            'no_handphone'   => $data['no_handphone'],
            'cabang_id'     => $this->id_cabang
        ];

        try {
            $update = $this->modelMekanik->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelMekanik->errors(); // mengambil data error
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
            $this->modelMekanik->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
