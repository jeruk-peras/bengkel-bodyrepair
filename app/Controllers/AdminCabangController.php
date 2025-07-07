<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\AdminCabangModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminCabangController extends BaseController
{
    private $title = 'Admin Cabang';
    private $modelAdmin;

    private $setRules = [
        'password'         => 'required|max_length[100]|password_strength',
        'confirm_password' => 'required|matches[password]',
    ];

    private $setMessage = [
        'password' => [
            'required'   => 'Password wajib diisi.',
            'max_length' => 'Password maksimal 100 karakter.',
            'password_strength' => 'Minimal 8 Karakter kombinasi huruf kapital, huruf kecil, angka dan simbol.',
        ],
        'confirm_password' => [
            'required' => 'Konfirmasi Password wajib diisi.',
            'matches'  => 'Konfirmasi Password harus sama dengan Password.',
        ],
    ];

    public function __construct()
    {
        $this->modelAdmin = new AdminCabangModel();
    }


    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/admin/index', $data);
    }

    public function save()
    {
        $data = $this->request->getPost(); // mengambil post data

        // rules tambahan
        $this->validator->setRules($this->setRules, $this->setMessage);
        $validate = $this->validator->run($data);
        if (!$validate) {
            $errors = $this->validator->getErrors(); // mengambil data error
            return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $data = [
            'id_admin'      => '',
            'nama_lengkap' => $data['nama_lengkap'],
            'no_handphone' => $data['no_handphone'],
            'alamat'       => $data['alamat'],
            'username'     => $data['username'],
            'password'     => password_hash($data['password'], PASSWORD_DEFAULT),
            'cabang_id'    => $data['cabang_id'],
            'by'           => $this->id_login,
            'status'       => 1,
        ];

        try {
            $save = $this->modelAdmin->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelAdmin->errors(); // mengambil data error
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
            $data = $this->modelAdmin->find($id); // mengambil data
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
            'id_admin'      => "$id",
            'nama_lengkap' => $data['nama_lengkap'],
            'no_handphone' => $data['no_handphone'],
            'alamat'       => $data['alamat'],
            'username'     => $data['username'],
            'cabang_id'    => $data['cabang_id'],
            'by'           => $this->id_login,
            'status'       => 1,
        ];

        try {
            $update = $this->modelAdmin->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelAdmin->errors(); // mengambil data error
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
            $this->modelAdmin->delete($id);
            return ResponseJSONCollection::success([], 'Data berhasil dihapus.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], 'Data tidak bisa dihapus.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function update_pass(int $id)
    {
        $data = $this->request->getPost(); // mengambil post data

        // set rules
        $this->validator->setRules($this->setRules, $this->setMessage);
        $validate = $this->validator->run($data); // melakukan validasi
        if (!$validate) {
            $errors = $this->validator->getErrors(); // mengambil data error
            return ResponseJSONCollection::error($errors, 'Data tidak valid.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $data = [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        try {
            $this->modelAdmin->skipValidation(); // skip validasi dari model, karena sudah melakukan validasi diatas
            $this->modelAdmin->update($id, $data); // update data

            return ResponseJSONCollection::success([], 'Password berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
