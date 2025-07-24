<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\MaterialModel;
use App\Models\StatusModel;
use App\Models\UnitMaterialModel;
use App\Models\UnitModel;
use App\Models\UnitStatusHargaModel;
use App\Models\UnitStatusModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class UnitController extends BaseController
{
    private $title = 'Unit';
    private $modelUnit;
    private $modelStatus;
    private $modelUnitStatus;
    private $modelUnitMaterial;

    public function __construct()
    {
        $this->modelUnit = new UnitModel();
        $this->modelStatus = new UnitStatusHargaModel();
        $this->modelUnitStatus = new UnitStatusModel();
        $this->modelUnitMaterial = new UnitMaterialModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/unit/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => $this->title,
        ];

        return view('pages/unit/add', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'nama_so'           => $data['nama_so'],
            'nomor_polisi'      => $data['nomor_polisi'],
            'model_unit'        => $data['model_unit'],
            'warna_unit'        => $data['warna_unit'],
            'asuransi_id'       => $data['asuransi_id'],
            'nomor_mesin'       => $data['nomor_mesin'],
            'nomor_rangka'      => $data['nomor_rangka'],
            'nomor_spp'         => $data['nomor_spp'],
            'tanggal_masuk'     => $data['tanggal_masuk'],
            'estimasi_selesai'  => $data['estimasi_selesai'],
            'detail_pengerjaan' => $data['detail_pengerjaan'],
            'harga_spp'         => $data['harga_spp'],
            'diskon'            => $data['diskon'],
            'jumlah_diskon'     => $data['jumlah_diskon'],
            'harga_panel'       => $data['harga_panel'],
            'jumlah_panel'      => $data['jumlah_panel'],
            'upah_mekanik'      => $data['upah_mekanik'],
            'total_upah_mekanik' => $data['total_upah_mekanik'],
            'status'            => 0,
            'cabang_id'         => $this->id_cabang,
        ];

        try {
            $this->db->transException(true)->transStart();
            $save = $this->modelUnit->save($data); // save data
            $id = $this->modelUnit->getInsertID(); // get id data save

            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelUnit->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            // save status unit // id diambil dari id unit
            $saveStatus = $this->_getDataStatus($id);
            if ($saveStatus !== true) {
                return ResponseJSONCollection::error($saveStatus, 'Terjadi kesalahan.', ResponseInterface::HTTP_BAD_REQUEST);
            }
            $this->db->transComplete();
            return ResponseJSONCollection::success(['redirect' => base_url('unit')], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function _getDataStatus($id_unit)
    {
        $modelStatus = new StatusModel(); // load model status
        // get all data status cabang
        $data = $modelStatus->where('cabang_id', $this->id_cabang)->findAll();
        $dataStatus = [];
        foreach ($data as $row) {
            $dataStatus[] = [
                'nama_status'   => $row['nama_status'],
                'harga_status'  => $row['harga_status'],
                'urutan'        => $row['urutan'],
                'unit_id'       => $id_unit
            ];
        }

        try {
            $save = $this->modelStatus->insertBatch($dataStatus); // save data 
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelStatus->errors(); // mengambil data error
                return $errors;
            }
            return true;
        } catch (\Throwable $e) {
            return $e;
        }
    }

    public function edit(int $id)
    {
        try {
            $data = $this->modelUnit->find($id); // mengambil data
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
            'nama_so'           => $data['nama_so'],
            'nomor_polisi'      => $data['nomor_polisi'],
            'model_unit'        => $data['model_unit'],
            'warna_unit'        => $data['warna_unit'],
            'asuransi_id'       => $data['asuransi_id'],
            'nomor_mesin'       => $data['nomor_mesin'],
            'nomor_rangka'      => $data['nomor_rangka'],
            'nomor_spp'         => $data['nomor_spp'],
            'tanggal_masuk'     => $data['tanggal_masuk'],
            'estimasi_selesai'  => $data['estimasi_selesai'],
            'detail_pengerjaan' => $data['detail_pengerjaan'],
            'harga_spp'         => $data['harga_spp'],
            'diskon'            => $data['diskon'],
            'jumlah_diskon'     => $data['jumlah_diskon'],
            'harga_panel'       => $data['harga_panel'],
            'jumlah_panel'      => $data['jumlah_panel'],
            'upah_mekanik'      => $data['upah_mekanik'],
            'total_upah_mekanik' => $data['total_upah_mekanik'],
            'status'            => 0,
            'cabang_id'         => $this->id_cabang,
        ];

        try {
            $update = $this->modelUnit->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelUnit->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success([], 'Data berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateStatus(int $id)
    {
        $dataPost = $this->request->getPost();
        $gambarStatus = $this->request->getFile('gambar_status');

        // validasi gambar
        $setRules = [
            'gambar_status' => [
                'rules'  => 'max_size[gambar_status,2048]|is_image[gambar_status]|mime_in[gambar_status,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'uploaded' => 'Maaf kolom gambar kosong!.',
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
        $path = './assets/images/status/';
        if ($gambarStatus) $fileName = UploadFileLibrary::uploadImage($gambarStatus, $path);

        $data = [
            'tanggal_update'        => date("Y-m-d H:i:s"),
            'unit_status_harga_id'  => $dataPost['unit_status_harga_id'],
            'catatan'               => $dataPost['catatan'] ?? '',
            'gambar_status'         => $fileName ?? NULL,
            'by_user'               => (session('nama_user') ?? 'Admin') . '-' . (session('role') ?? ''),
            'unit_id'               => $id,
        ];

        try {
            $update = $this->modelUnitStatus->save($data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelUnitStatus->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success(['id_unit' => $id], 'Status berhasil diupdate.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function statusUpdate(int $id)
    {
        $data = [
            'status' => 1,
        ];

        try {
            $update = $this->modelUnit->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelUnit->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            return ResponseJSONCollection::success(['id_unit' => $id], 'Data Status diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(int $id)
    {
        try {
            $data = $this->modelUnit->select('unit.*, asuransi.nama_asuransi')->join('asuransi', 'unit.asuransi_id = asuransi.id_asuransi', '')->find($id); // mengambil data
            // jika data tidak ditemukan
            if (!$data) {
                return ResponseJSONCollection::error([], 'Data tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $data['asuransi_id'] = $data['nama_asuransi'];
            $data['tanggal_masuk'] = date_format(date_create($data['tanggal_masuk']), "d M Y");
            $data['estimasi_selesai'] = date_format(date_create($data['estimasi_selesai']), "d M Y");
            $data['harga_spp'] = number_format($data['harga_spp']);
            $data['diskon'] = $data['diskon'] . '%';
            $data['jumlah_diskon'] = number_format($data['jumlah_diskon']);
            $data['total_upah_mekanik'] = number_format($data['total_upah_mekanik']);

            return ResponseJSONCollection::success($data, 'Data ditemukan.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function saveMaterial(int $id_unit = 0)
    {
        $dataPost = $this->request->getPost();

        try {
            $this->db->transException(true)->transStart();
            foreach ($dataPost['material_id'] as $key => $value) {
                $data[] = [
                    'material_id'   => $value,
                    'tanggal'       => date("Y-m-d H:i:s"),
                    'harga'         => $dataPost['harga'][$key],
                    'jumlah'        => $dataPost['jumlah'][$key],
                    'detail_jumlah' => $dataPost['detail_jumlah'][$key],
                    'mekanik_id'    => $dataPost['mekanik_id'],
                    'unit_id'       => $id_unit,
                ];

                // update stok material
                $updateStok = $this->_updateStokMaterial($value, $dataPost['jumlah'][$key]);
            }

            $save = $this->modelUnitMaterial->insertBatch($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelUnitMaterial->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }
            $this->db->transComplete();
            return ResponseJSONCollection::success(['url' => "/unit/$id_unit/detail", 'id' => $id_unit], 'Data Status diubah.', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function _updateStokMaterial($id_material, $jumlah)
    {
        $modelMaterial = new MaterialModel();
        $material = $modelMaterial->find($id_material);
        try {
            if ($material) {
                $stok = $material['stok'] - $jumlah;
                if ($stok < 0) {
                    return ResponseJSONCollection::error([], 'Stok material tidak cukup.', ResponseInterface::HTTP_BAD_REQUEST);
                }
                $modelMaterial->update($id_material, ['stok' => $stok]);
            } else {
                return ResponseJSONCollection::error([], 'Material tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan saat mengupdate stok material.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id)
    {
        try {
            // hapus gambar status jika ada
            $statusData = $this->modelUnitStatus->where('unit_id', $id)->findAll();
            foreach ($statusData as $status) {
                $this->_deleteGambarStatus($status['gambar_status']);
            }
            
            $delete = $this->modelUnit->delete($id); // delete data
            // jika delete gagal maka
            if (!$delete) {
                $errors = $this->modelUnit->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }


            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function _deleteGambarStatus($gambar)
    {
        // define('EXT', '.' . pathinfo(__FILE__, PATHINFO_EXTENSION));
        // define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
        // define('PUBPATH', str_replace(SELF, '', FCPATH)); 
        
        if ($gambar && file_exists('./assets/images/status/' . $gambar)) {
            unlink('assets/images/status/' . $gambar); // hapus gambar
        }
    }
}
