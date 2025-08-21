<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\MaterialModel;
use App\Models\UnitMaterialModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class MaterialKeluarController extends BaseController
{
    private $title = 'Material Keluar';
    private $modelUnitMaterial;

    public function __construct()
    {
        $this->modelUnitMaterial = new UnitMaterialModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/material_keluar/index', $data);
    }

    public function mixing()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/mixing/index', $data);
    }

    public function save(int $id_unit)
    {
        $dataPost = $this->request->getPost();

        try {
            $this->db->transException(true)->transStart();
            foreach ($dataPost['material_id'] as $key => $value) {
                $data[] = [
                    'material_id'   => $value,
                    'tanggal'       => date("Y-m-d H:i:s"),
                    'harga'         => str_replace('.', '', $dataPost['harga'][$key]),
                    'jumlah'        => $dataPost['jumlah'][$key],
                    'total_harga'   => $dataPost['total_harga'][$key],
                    'mekanik_id'    => $dataPost['mekanik_id'],
                    'unit_id'       => $id_unit,
                ];

                // update stok material
                $update = $this->_updateStokMaterial($value, $dataPost['jumlah'][$key]);
            }

            $save = $this->modelUnitMaterial->insertBatch($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelUnitMaterial->errors(); // mengambil data error
                return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
            }
            $this->db->transComplete();
            return ResponseJSONCollection::success(['url' => "/unit/$id_unit/detail", 'id' => $id_unit], 'Data berhasil disimpan.', ResponseInterface::HTTP_OK);
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
                $stok = ($material['stok'] - $jumlah);
                if ($stok < 0) {
                    return ResponseJSONCollection::error([], 'Stok material tidak cukup.', ResponseInterface::HTTP_BAD_REQUEST);
                }
                return $modelMaterial->update($id_material, ['stok' => $stok]);
            } else {
                return ResponseJSONCollection::error([], 'Material tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan saat mengupdate stok material.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchMaterialUnit(int $id)
    {
        $model = new UnitMaterialModel();
        try {
            $data = $model
                ->select('unit_material.*, material.nama_material, material.merek, material.harga, material.stok, satuan.nama_satuan, jenis.nama_jenis')
                ->join('material', 'material.id_material = unit_material.material_id', 'left')
                ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
                ->where('unit_material.unit_id', $id)
                ->whereNotIn('jenis.nama_jenis', ['Paint'])
                ->orderBy('unit_material.tanggal', 'DESC')
                ->orderBy('jenis.nama_jenis', 'ASC')
                ->findAll();

            $html = '';

            $i = 1;
            foreach ($data as $row) {
                $html .=
                    '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $row['nama_jenis'] . '</td>
                        <td>' . $row['nama_material'] . '</td>
                        <td>Rp' . number_format($row['harga'], 0, '', '.') . '</td>
                        <td>' . $row['jumlah'] . '</td>
                        <td>' . $row['nama_satuan'] . '</td>
                        <td>Rp' . number_format($row['total_harga'], 0, '', '.') . '</td>
                        <td>' . $row['tanggal'] . '</td>
                        <td><a href="/material-keluar/' . $row['id_unit_material'] . '/delete" class="btn btn-danger btn-sm btn-del"><i class="bx bx-trash me-0"></i></a></td>
                    </tr>';
            }


            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchMaterialMixing(int $id)
    {
        $model = new UnitMaterialModel();
        try {
            $data = $model
                ->select('unit_material.*, material.nama_material, material.merek, material.harga, material.stok, satuan.nama_satuan, jenis.nama_jenis')
                ->join('material', 'material.id_material = unit_material.material_id', 'left')
                ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
                ->where('unit_material.unit_id', $id)
                ->whereIn('jenis.nama_jenis', ['Paint'])
                ->orderBy('unit_material.tanggal', 'DESC')
                ->orderBy('jenis.nama_jenis', 'ASC')
                ->findAll();

            $html = '';

            $i = 1;
            foreach ($data as $row) {
                $html .=
                    '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $row['nama_jenis'] . '</td>
                        <td>' . $row['nama_material'] . '</td>
                        <td>Rp' . number_format($row['harga'], 0, '', '.') . '</td>
                        <td>' . $row['jumlah'] . '</td>
                        <td>' . $row['nama_satuan'] . '</td>
                        <td>Rp' . number_format($row['total_harga'], 0, '', '.') . '</td>
                        <td>' . $row['tanggal'] . '</td>
                        <td><a href="/material-keluar/' . $row['id_unit_material'] . '/delete" class="btn btn-danger btn-sm btn-del"><i class="bx bx-trash me-0"></i></a></td>
                    </tr>';
            }


            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function editPenggunaanMaterial(int $id)
    {
        try {
            // get data pemakaian material
            $data = $this->db->table('unit_material um')
                ->select('um.tanggal, m.id_material, m.nama_material, m.stok, s.nama_satuan, um.id_unit_material, um.harga, um.jumlah, um.total_harga, mk.id_mekanik, mk.nama_mekanik')
                ->join('mekanik mk', 'mk.id_mekanik = um.mekanik_id')
                ->join('material m', 'm.id_material = um.material_id')
                ->join('satuan s', 's.id_satuan = m.satuan_id')
                ->where('um.id_unit_material', $id)
                ->get()->getRowArray();
            
            $data['total_harga'] = round($data['total_harga']);

            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function updatePenggunaanMaterial(int $id)
    {
        $this->db->transStart();
        try {
            $post = $this->request->getPost();

            // get data pemakaian material
            $data = $this->db->table('unit_material um')->where('um.id_unit_material', $id)->get()->getRowArray();

            $updateData = [
                'id_unit_material'  => $id,
                'mekanik_id'        => $post['mekanik_id'],
                'tanggal'           => $post['tanggal'],
                'harga'             => str_replace('.', '', $post['harga']),
                'jumlah'            => $post['jumlah'],
                'total_harga'       => $post['total_harga'],
            ];

            // cek apakah id materil berubah
            if ($data['material_id'] !== $post['material_id']) $updateData['material_id'] = $post['material_id'];

            // gunakan aritmatika langsung dari query untuk menhindari race condition
            // kembalikan stok yang sebelumnya
            $this->db->table('material')->where('id_material', $data['material_id'])
                ->set('stok', 'stok + ' . $data['jumlah'], false)->update();

            // kurangi stok material
            $this->db->table('material')->where('id_material', $post['material_id'])
                ->set('stok', 'stok - ' . $post['jumlah'], false)->update();

            // update data
            $this->db->table('unit_material')->update($updateData, ['id_unit_material' => $id]);

            $this->db->transComplete();
            return ResponseJSONCollection::success([], 'Berhasil update data', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function delete(int $id)
    {
        try {
            // get data
            $unitMaterial = $this->modelUnitMaterial->find($id);
            $modelMaterial = new MaterialModel();
            $material = $modelMaterial->find($unitMaterial['material_id']);

            // perhitungan stok
            $stok_baru = $material['stok'] + $unitMaterial['jumlah'];

            // update stok material
            $update = $modelMaterial->update($material['id_material'], ['stok' => $stok_baru]);

            if ($update) $this->modelUnitMaterial->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
