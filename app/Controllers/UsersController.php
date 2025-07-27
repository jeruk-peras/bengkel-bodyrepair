<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseController
{
    private $title = 'Users';
    private $modelUsers;

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
        $this->modelUsers = new UsersModel();
    }


    public function index()
    {
        $data = [
            'title' => $this->title,
        ];
        return view('pages/users/index', $data);
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
            'id_user'      => '',
            'nama_lengkap' => $data['nama_lengkap'],
            'no_handphone' => $data['no_handphone'],
            'alamat'       => $data['alamat'],
            'username'     => $data['username'],
            'password'     => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'         => $data['role'],
            'by'           => $this->id_login,
            'status'       => 1,
        ];


        try {
            $save = $this->modelUsers->save($data); // save data
            // jika save gagal maka
            if (!$save) {
                $errors = $this->modelUsers->errors(); // mengambil data error
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
            $data = $this->modelUsers->find($id); // mengambil data
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
            'id_user'      => "$id",
            'nama_lengkap' => $data['nama_lengkap'],
            'no_handphone' => $data['no_handphone'],
            'alamat'       => $data['alamat'],
            'username'     => $data['username'],
            'role'         => $data['role'],
            'by'           => $this->id_login,
            'status'       => 1,
        ];

        try {
            $update = $this->modelUsers->update($id, $data); // update data
            // jika update gagal maka
            if (!$update) {
                $errors = $this->modelUsers->errors(); // mengambil data error
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
            $this->modelUsers->delete($id);
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
            $this->modelUsers->skipValidation(); // skip validasi dari model, karena sudah melakukan validasi diatas
            $this->modelUsers->update($id, $data); // update data

            return ResponseJSONCollection::success([], 'Password berhasil diubah.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function akses()
    {
        $role = [];
        (session('user_type') == 'admin' && session('role') == 'Admin') ? $role = ['Admin Cabang'] : $role = ['Admin Cabang', 'Admin', 'Super Admin'];

        $data = [
            'title' => 'User Akses',
            'cabang' => $this->db->table('cabang')->get()->getResultArray(),
            'users' => $this->db->table('users')->where('role', $role)->get()->getResultArray(),
        ];
        return view('pages/users/akses', $data);
    }

    public function akses_add(int $id)
    {
        $data['title'] = 'User Akses';
        $data['user'] = $this->db->table('users')
            ->where('id_user', $id)
            ->get()
            ->getRowArray();

        $data['cabang'] = $this->db->table('cabang')->get()->getResultArray();


        return view('pages/users/akses_add', $data);
    }

    public function akses_save(int $id)
    {
        $akses = $this->request->getPost('cabang') ?? [];
        $data = [];
        foreach ($akses as $key => $val) {
            $data[] = [
                'user_id' => $id,
                'cabang_id' => $key,
            ];
        }

        try {
            // hapus data akses 
            $this->db->table('users_cabang')->where('user_id', $id)->delete();
            // insert data baru
            $this->db->table('users_cabang')->insertBatch($data);

            return redirect()->to('users/akses')->with('message', 'Akses Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->to('users/akses')->with('message', $th->getMessage());
        }
    }
}
