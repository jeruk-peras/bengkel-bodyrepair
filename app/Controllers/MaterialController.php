<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\MaterialModel;
use CodeIgniter\HTTP\ResponseInterface;

class MaterialController extends BaseController
{
    private $title = 'Material';
    private $modelMaterial;

    public function __construct()
    {
        $this->modelMaterial = new MaterialModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/material/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'nama_material'  => $data['nama_material'],
            'merek'          => $data['merek'],
            'harga'          => str_replace('.', '', $data['harga']),
            'stok'           => $data['stok'],
            'satuan_id'      => $data['satuan_id'],
            'jenis_id'       => $data['jenis_id'],
            'cabang_id'      => $this->id_gudang ?? $this->id_cabang
        ];

        try {
            $save = $this->modelMaterial->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelMaterial->errors(); // mengambil data error
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
            $data = $this->modelMaterial->find($id); // mengambil data
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
            'nama_material'  => $data['nama_material'],
            'merek'          => $data['merek'],
            'harga'          => str_replace('.', '', $data['harga']),
            'stok'           => $data['stok'],
            'satuan_id'      => $data['satuan_id'],
            'jenis_id'       => $data['jenis_id'],
            'cabang_id'      => $this->id_gudang ?? $this->id_cabang
        ];

        try {
            $update = $this->modelMaterial->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelMaterial->errors(); // mengambil data error
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
            $this->modelMaterial->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
