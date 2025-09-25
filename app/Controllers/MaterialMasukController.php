<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\MaterialMasukDetailModel;
use App\Models\MaterialMasukModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class MaterialMasukController extends BaseController
{
    private $title = 'Material';
    private $modelMaterialMasuk;
    private $modelMaterialMasukDetail;

    public function __construct()
    {
        $this->modelMaterialMasuk = new MaterialMasukModel();
        $this->modelMaterialMasukDetail = new MaterialMasukDetailModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/material_masuk/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/material_masuk/add', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'tanggal'      => $data['tanggal'],
            'no_delivery'  => $data['no_delivery'],
            'suplier'      => $data['suplier'],
            'total_harga'  => $data['total_harga'],
            'catatan'      => $data['catatan'],
            'cabang_id'      => $this->id_gudang ?? $this->id_cabang
        ];

        try {
            $save = $this->modelMaterialMasuk->save($data); // save data
            $id = $this->modelMaterialMasuk->getInsertID();
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelMaterialMasuk->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success(['redirect' => base_url('material-masuk/item/' . $id)], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    // item ###############
    public function item(int $id)
    {
        $data = [
            'title' => $this->title,
        ];
        
        $data['data'] = $this->modelMaterialMasuk->find($id);
        
        // check apakah data sudah di singkron
        if($data['data']['status'] == 1) return ResponseJSONCollection::error($data['data'], 'Data sudah disingkron sebelummnya.', ResponseInterface::HTTP_BAD_REQUEST);


        return view('pages/material_masuk/item', $data);
    }

    public function itemAdd(int $id)
    {
        // check selected akses cabang
        // $checkSelectedAkses = $this->db->table('material_masuk')
        //     ->where(['id_material_masuk' => $id, 'cabang_id' => session('selected_akses')])
        //     ->countAllResults();
        // if ($checkSelectedAkses == 0) return ResponseJSONCollection::error([], 'Pilih akses yang sesuai.', ResponseInterface::HTTP_BAD_REQUEST);

        $data = $this->request->getPost(); // mengambil data post id

        // mengambil data material
        $data = $this->db->table('material')
            ->where('id_material', $data['id_material'])
            ->get()->getRowArray();

        // validasi data
        if (!$data) return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);

        // cek apakah data sudah masuk atau belum
        $itemCheck = $this->db->table('material_masuk_detail')
            ->where(['material_masuk_id' => $id, 'material_id' => $data['id_material']])
            ->countAllResults();
        if ($itemCheck > 0) return ResponseJSONCollection::error([], 'Item sudah dimasukan.', ResponseInterface::HTTP_BAD_REQUEST);

        $data = [
            'material_masuk_id' => $id,
            'material_id' => $data['id_material'],
            'harga_masuk' => $data['harga'],
            'stok_masuk' => 0,
        ];

        try {
            $insert = $this->modelMaterialMasukDetail->insert($data); // insert data
            // jika insert gagal maka
            if (!$insert) {
                $errors = $this->modelMaterialMasukDetail->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Item ditambahkan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function itemTempSave()
    {
        $dataPost = $this->request->getPost(); // mengambil data post

        $data = [];
        foreach ($dataPost['id_material_masuk_detail'] as $key => $value) {
            $data[] = [
                'id_material_masuk_detail' => $value,
                'harga_masuk' => str_replace('.', '', $dataPost['harga_masuk'][$value]),
                'stok_masuk' => $dataPost['stok_masuk'][$value] ?: 0,
            ];
        }

        try {
            $this->modelMaterialMasukDetail->updateBatch($data, 'id_material_masuk_detail'); // update data

            return ResponseJSONCollection::success([], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function itemSyncData()
    {
        $dataPost = $this->request->getPost(); // mengambil data post

        $updateMaterial = [];
        $updateDetail = [];

        foreach ($dataPost['id_material_masuk_detail'] as $key => $value) {

            $detailMasuk = $this->modelMaterialMasukDetail->find($value);

            $meterial = $this->db->table('material')
                ->where(['id_material' => $detailMasuk['material_id']])
                ->get()->getRowArray();

            // perhitunga stok | stok lama + stok masuk
            $stokBaru = ($meterial['stok'] + $detailMasuk['stok_masuk']);

            // perhitungan harga
            $harga = ($detailMasuk['harga_masuk'] - $meterial['harga']);
            // $backharga = ($detailMasuk['harga_masuk'] - $harga);


            $updateMaterial[] = [
                'id_material' => $meterial['id_material'],
                'harga' => $detailMasuk['harga_masuk'],
                'stok' => $stokBaru,
            ];

            $updateDetail[] = [
                'id_material_masuk_detail' => $value,
                'harga_masuk' => $harga,
                // 'harga_baru' => $detailMasuk['harga_masuk'],
                // 'harga_old' => $backharga,
                'stok_masuk' => $detailMasuk['stok_masuk'],
            ];
        }
        try {
            $this->db->transException(true)->transStart();
            // update data material
            $this->db->table('material')->updateBatch($updateMaterial, 'id_material');

             // update meterial masuk
            $this->modelMaterialMasuk->update($dataPost['id_material_masuk'], ['status' => 1]);

            // update data detail material masuk
            $this->modelMaterialMasukDetail->skipValidation();
            $this->modelMaterialMasukDetail->updateBatch($updateDetail, 'id_material_masuk_detail'); // update data
            $this->db->transComplete();

            return ResponseJSONCollection::success(['redirect' => base_url('material-masuk')], 'Sinkron Berhasil.', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function itemCancelSyncData() {
        $id = $this->request->getPost('id_material_masuk');

        $data = $this->modelMaterialMasukDetail->where('material_masuk_id', $id)->findAll();

        $updateMaterial = [];
        $updateDetail = [];

        foreach($data as $detailMasuk){

            $meterial = $this->db->table('material')
                ->where(['id_material' => $detailMasuk['material_id']])
                ->get()->getRowArray();

            // perhitunga stok | stok lama - stok masuk
            $stokBaru = ($meterial['stok'] - $detailMasuk['stok_masuk']);

            // perhitungan harga | harga material - harga masuk
            $harga = ($meterial['harga'] - $detailMasuk['harga_masuk']);

            $updateMaterial[] = [
                'id_material' => $meterial['id_material'],
                'harga' => $harga,
                'stok' => $stokBaru,
            ];

            $updateDetail[] = [
                'id_material_masuk_detail' => $detailMasuk['id_material_masuk_detail'],
                'harga_masuk' => $harga,
                'stok_masuk' => $detailMasuk['stok_masuk'],
            ];
        }

        try {
            $this->db->transException(true)->transStart();
            // update data material
            $this->db->table('material')->updateBatch($updateMaterial, 'id_material');

            // update meterial masuk
            $this->modelMaterialMasuk->update($id, ['status' => 0]);

            // update data detail material masuk
            $this->modelMaterialMasukDetail->skipValidation();
            $this->modelMaterialMasukDetail->updateBatch($updateDetail, 'id_material_masuk_detail'); // update data
            $this->db->transComplete();

            return ResponseJSONCollection::success(['redirect' => base_url('material-masuk')], 'Sinkron dibatalkan.', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function itemDelete()
    {
        $data = $this->request->getPost('id'); // mengambil data post id
        try {
            $this->modelMaterialMasukDetail->delete($data);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
    // item ###############

    public function edit(int $id)
    {
        try {
            $data = $this->modelMaterialMasuk->find($id); // mengambil data
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
            'tanggal'      => $data['tanggal'],
            'no_delivery'  => $data['no_delivery'],
            'suplier'      => $data['suplier'],
            'total_harga'  => $data['total_harga'],
            'catatan'      => $data['catatan'],
            'cabang_id'      => $this->id_gudang ?? $this->id_cabang
        ];

        try {
            $update = $this->modelMaterialMasuk->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelMaterialMasuk->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id)
    {

        if($this->modelMaterialMasuk->find($id)['status'] == 1)  return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $this->modelMaterialMasuk->delete($id);
            return ResponseJSONCollection::success(['redirect' => base_url('material-masuk')], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
