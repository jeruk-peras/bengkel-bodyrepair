<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\SettingBiayaModel;
use CodeIgniter\HTTP\ResponseInterface;

class SettingBiayaController extends BaseController
{
    private $title = 'Setting Biaya';
    private $modelBiaya;

    public function __construct()
    {
        $this->modelBiaya = new SettingBiayaModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/biaya/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'id_setting_biaya' => '',
            'diskon' => $data['diskon'],
            'harga_panel' => str_replace('.', '', $data['harga_panel']),
            'upah_mekanik' => str_replace('.', '', $data['upah_mekanik']),
            'sharing' => $data['sharing'],
            'cabang_id'     => $this->id_cabang
        ];

        try {
            $save = $this->modelBiaya->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelBiaya->errors(); // mengambil data error
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
            $data = $this->modelBiaya->find($id); // mengambil data
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
            'id_setting_biaya' => "$id",
            'diskon' => $data['diskon'],
            'harga_panel' => str_replace('.', '', $data['harga_panel']),
            'upah_mekanik' => str_replace('.', '', $data['upah_mekanik']),
            'sharing' => $data['sharing'],
            'cabang_id'     => $this->id_cabang
        ];

        try {
            $update = $this->modelBiaya->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelBiaya->errors(); // mengambil data error
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
            $this->modelBiaya->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
