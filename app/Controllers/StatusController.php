<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\StatusModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class StatusController extends BaseController
{
    private $title = 'Status';
    private $modelStatus;

    public function __construct()
    {
        $this->modelStatus = new StatusModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
        ];

        $table = 'status';
        $columns = ['status.id_status', 'status.nama_status', 'status.harga_status', 'status.urutan', 'cabang.nama_cabang', 'cabang.id_cabang'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = status.cabang_id',
                'type' => ''
            ]
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'status.cabang_id IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'status.cabang_id IN' => [session('selected_akses')]
            ];
        }

        $builder = $this->db->table($table);
        $builder->select($columns);
        $builder->join($join[0]['table'], $join[0]['on']);
        if ($where) {
            foreach ($where as $key => $val) {
                if (stripos($key, ' IN') !== false && is_array($val)) {
                    $field = trim(str_ireplace('IN', '', $key));
                    $builder->whereIn($field, $val);
                } else {
                    $builder->where($key, $val);
                }
            }
        }
        $builder->orderBy('status.urutan', 'ASC');

        $query = $builder->get();
        $data['data'] = $query->getResultArray();

        $sql = $this->db->table($table);
        $sql->select($columns);
        $sql->join($join[0]['table'], $join[0]['on']);
        if ($where) {
            foreach ($where as $key => $val) {
                if (stripos($key, ' IN') !== false && is_array($val)) {
                    $field = trim(str_ireplace('IN', '', $key));
                    $sql->whereIn($field, $val);
                } else {
                    $sql->where($key, $val);
                }
            }
        }
        $sql->groupBy('cabang.id_cabang');

        $query = $sql->get();
        $data['cabang'] = $query->getResultArray();

        return view('pages/status/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        $data = [
            'nama_status'     => strtoupper($data['nama_status']),
            'harga_status'   => $data['harga_status'],
            'cabang_id'     => $this->id_cabang
        ];

        try {
            $save = $this->modelStatus->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelStatus->errors(); // mengambil data error
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
            $data = $this->modelStatus->find($id); // mengambil data
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
            'nama_status'     => strtoupper($data['nama_status']),
            'harga_status'   => $data['harga_status'],
            'cabang_id'     => $this->id_cabang
        ];

        try {
            $update = $this->modelStatus->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelStatus->errors(); // mengambil data error
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
            $this->modelStatus->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function orderData()
    {
        $arrayPostOrder = $this->request->getPost('posisi');
        $order = [];
        foreach ($arrayPostOrder as $key => $row) {
            if (count($row) < 2) continue;

            $order[] = [
                'id_status' => $row['id'],
                'urutan' => $row['order']
            ];
        }

        try {
            $this->modelStatus->updateBatch($order, 'id_status');
            return ResponseJSONCollection::success([], 'Success', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e], 'Error', ResponseInterface::HTTP_OK);
        }
    }
}
