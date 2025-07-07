<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\UsersModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class AccountController extends BaseController
{
    public function loginPage()
    {
        return view('login');
    }

    public function validLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $akses = [];

        // Cek di tabel users
        $userModel = new \App\Models\UsersModel();
        $user = $userModel->where('username', $username)->first();

        // Jika tidak ada di users, cek di admin_cabang
        if (!$user) {
            $adminModel = new \App\Models\AdminCabangModel();
            $user = $adminModel->where('username', $username)->first();
            $akses = $user['cabang_id'];
            $userType = 'admin_cabang';
        } else {

            $db = \Config\Database::connect();
            $builder = $db->table('users_cabang')->select('cabang.id_cabang, cabang.nama_cabang');
            $builder->join('cabang', 'cabang.id_cabang = users_cabang.cabang_id');
            $builder->where('users_cabang.user_id', $user['id_user']);
            $results = $builder->get()->getResultArray();

            foreach ($results as $row) {
                $akses[] = $row['id_cabang'];
            }

            $userType = 'admin';
        }

        // Jika tidak ditemukan di kedua tabel
        if (!$user || !password_verify($password, $user['password'])) {
            return ResponseJSONCollection::error([$user], 'Username atau password salah', ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Set session sesuai tipe user
        session()->set([
            'user_id'   => $user['id_user'] ?? $user['id_admin'],
            'nama_user' => $user['nama_lengkap'],
            'username'  => $user['username'],
            'role'      => $user['role'] ?? $userType,
            'logged_in' => true,
            'user_type' => $userType,
            'akses_cabang' => $akses,
            'selected_akses' => $akses
        ]);

        return ResponseJSONCollection::success(['redirect' => base_url('dashboard')], 'Login berhasil.', ResponseInterface::HTTP_OK);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function selectAksess()
    {
        $id = $this->request->getPost('key');
        if ($id == 'all') {
            session()->set('selected_akses', session('akses_cabang'));
            return ResponseJSONCollection::success([$id], 'Akses Cabang ditemukan.', ResponseInterface::HTTP_OK);
        }

        $id_user = session('user_id');
        $role = session('user_type');

        try {
            if ($role == 'admin_cabang') {
                $builder = $this->db->table('admin_cabang')->select('admin_cabang.cabang_id');
                $builder->where('admin_cabang.id_admin', $id_user);
                $builder->where('admin_cabang.cabang_id', $id);
                $data = $builder->get()->getRowArray();
                $results = $builder->get()->getNumRows();
            } else {
                $builder = $this->db->table('users_cabang')->select('users_cabang.cabang_id');
                $builder->where('users_cabang.user_id', $id_user);
                $builder->where('users_cabang.cabang_id', $id);
                $data = $builder->get()->getRowArray();
                $results = $builder->get()->getNumRows();
            }
            if ($results > 0) {
                session()->set('selected_akses', $data['cabang_id']);
                return ResponseJSONCollection::success([$data], 'Akses Cabang ditemukan.', ResponseInterface::HTTP_OK);
            }
            return ResponseJSONCollection::error([], 'Akses Cabang tidak ditemukan.', ResponseInterface::HTTP_BAD_REQUEST);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e], 'Terjadi kesalahan.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
