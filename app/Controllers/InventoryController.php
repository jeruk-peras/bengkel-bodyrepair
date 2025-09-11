<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\InventoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryController extends BaseController
{
    private $title = 'Inventory';
    private $modelInventory;

    public function __construct()
    {
        $this->modelInventory = new InventoryModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/inventory/index', $data);
    }

    public function data()
    {
        try {
            $data = [
                'item' => $this->modelInventory->findAll(),
            ];

            $html = view('pages/inventory/side_data', $data);
            return ResponseJSONCollection::success(['html' => $html], 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data
        $gambar = $this->request->getFile('gambar');

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
        $isValid = $this->validator->run($data);

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return ResponseJSONCollection::error($errors, 'Validasi gagal', ResponseInterface::HTTP_BAD_REQUEST);
        }
        // end validasi gambar

        // upload gambar
        $path = './assets/images/inventory/';
        if ($gambar) $fileName = UploadFileLibrary::uploadImage($gambar, $path);

        $data = [
            'nama_barang' => $data['nama_barang'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $fileName
        ];

        try {
            $save = $this->modelInventory->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelInventory->errors(); // mengambil data error
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
            $data = $this->modelInventory->find($id); // mengambil data
            // jika data tidak ditemukan
            if (!$data) {
                return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $data['gambar'] = "/assets/images/inventory/" . $data['gambar'];

            return ResponseJSONCollection::success($data, 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id)
    {
        $data = $this->request->getPost(); // mengambil post data
        $gambar = $this->request->getFile('gambar');

        // validasi gambar
        $setRules = [
            'gambar' => [
                'rules'  => 'permit_empty|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

        $this->validator->setRules($setRules);
        $isValid = $this->validator->run($data);

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return ResponseJSONCollection::error($errors, 'Validasi gagal', ResponseInterface::HTTP_BAD_REQUEST);
        }
        // end validasi gambar

        // upload gambar
        $olGambar = $this->modelInventory->find($id)['gambar'];
        $path = './assets/images/inventory/';
        if ($gambar) {
            $fileName = UploadFileLibrary::uploadImage($gambar, $path);

            // hapus gambar
            unlink($path . $olGambar);
        }


        $data = [
            'nama_barang' => $data['nama_barang'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $fileName ?? $olGambar
        ];

        try {
            $save = $this->modelInventory->update($id, $data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelInventory->errors(); // mengambil data error
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
            // hapus gambar
            $gambar = $this->modelInventory->find($id)['gambar'];
            $path = './assets/images/inventory/';
            unlink($path . $gambar);

            $this->modelInventory->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function assets()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/inventory/data', $data);
    }

    public function assets_edit(int $id)
    {
        try {
            // mengambil data
            $data = $this->db->table('inventory i')
                ->select('ic.id_inventory_cabang, ic.inventory_id, i.nama_barang, i.deskripsi, i.gambar, ic.jumlah, ic.rusak, ic.catatan, ic.gambar_kondisi')
                ->join('inventory_cabang ic', "ic.inventory_id = i.id_inventory AND ic.cabang_id = $this->id_cabang", 'LEFT')
                ->where(['i.id_inventory' => $id])->get()->getRowArray();

            //jika data tidak ditemukan
            if (!$data) {
                return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $data['gambar'] = "/assets/images/inventory/" . $data['gambar'];
            $data['gambar_kondisi'] = "/assets/images/inventory/kondisi/" . $data['gambar_kondisi'];

            return ResponseJSONCollection::success($data, 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assets_save(int $id)
    {
        $data = $this->request->getPost(); // mengambil post data
        $gambar = $this->request->getFile('gambar');

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
        $isValid = $this->validator->run($data);

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return ResponseJSONCollection::error($errors, 'Validasi gagal', ResponseInterface::HTTP_BAD_REQUEST);
        }
        // end validasi gambar

        // upload gambar
        $olGambar = $this->db->table('inventory_cabang')->select('gambar_kondisi')->where(['inventory_id' => $id, 'cabang_id' => $this->id_cabang])->get()->getRowArray();
        $path = './assets/images/inventory/kondisi/';
        if ($gambar)  $fileName = UploadFileLibrary::uploadImage($gambar, $path);

        // hapus gambar
        if ($olGambar && !empty($olGambar['gambar_kondisi'])) {
            $filePath = $path . $olGambar['gambar_kondisi'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }


        $data = [
            'inventory_id' => $id,
            'jumlah' => $data['jumlah'],
            'rusak' => $data['rusak'],
            'catatan' => $data['catatan'],
            'gambar_kondisi' => $fileName ?? $olGambar,
            'cabang_id' => $this->id_cabang,
        ];

        try {
            $checkData = $this->db->table('inventory_cabang')->where(['inventory_id' => $id, 'cabang_id' => $this->id_cabang])->countAllResults();
            if ($checkData > 0) {
                // update data
                $this->db->table('inventory_cabang')->update($data, ['inventory_id' => $id, 'cabang_id' => $this->id_cabang]);
            } else {
                // save data
                $this->db->table('inventory_cabang')->insert($data);
            }

            return ResponseJSONCollection::success([], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assets_gambar_kondisi(int $id)
    {
        try {
            // mengambil data
            $data = $this->db->table('inventory i')
                ->select('i.nama_barang, ic.gambar_kondisi')
                ->join('inventory_cabang ic', "ic.inventory_id = i.id_inventory AND ic.cabang_id = $this->id_cabang", 'LEFT')
                ->where(['i.id_inventory' => $id])->get()->getRowArray();

            //jika data tidak ditemukan
            if (!$data) {
                return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $data['gambar_kondisi'] = "/assets/images/inventory/kondisi/" . $data['gambar_kondisi'];

            return ResponseJSONCollection::success($data, 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
