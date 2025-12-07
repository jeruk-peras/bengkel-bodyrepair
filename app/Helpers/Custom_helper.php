<?php

// untuk kebutuhan edit aksess // memesiksa apakah sudah ada akses cabang

use Config\Publisher;

function userAkasesCabang(int $id_user, int $id_cabang)
{
    // global $db;
    $db = \Config\Database::connect();
    $builder = $db->table('users_cabang');
    $builder->where('user_id', $id_user);
    $builder->where('cabang_id', $id_cabang);
    $result = $builder->get()->getRow();

    if ($result) {
        return $result->id_user_cabang;
    }
    return null;
}

// memberikan list akses cabang
function userAkases(int $id_user)
{
    // global $db;
    $db = \Config\Database::connect();
    $builder = $db->table('users_cabang');
    $builder->select('cabang.nama_cabang');
    $builder->join('cabang', 'cabang.id_cabang = users_cabang.cabang_id');
    $builder->where('users_cabang.user_id', $id_user);
    $results = $builder->get()->getResult();

    if ($results) {
        $list = '<ol>';
        foreach ($results as $row) {
            $list .= '<li>' . htmlspecialchars($row->nama_cabang) . '</li>';
        }
        return $list .= '</ol>';
    }
}

function aksesCabang()
{
    $db = \Config\Database::connect();
    $id_user = session('user_id');

    $builder = $db->table('users_cabang')->select('cabang.id_cabang, cabang.nama_cabang');
    $builder->join('cabang', 'cabang.id_cabang = users_cabang.cabang_id');
    $builder->where('users_cabang.user_id', $id_user);
    $builder->orderBy('cabang.nama_cabang', 'ASC');
    $results = $builder->get()->getResultArray();

    return $results;
}

// memberikan data user login
function dataUser($data)
{
    $db = \Config\Database::connect();
    $id_user = session('user_id');

    $builder = $db->table('users')->select($data);
    $builder->where('users.id_user', $id_user);
    $results = $builder->get()->getRowArray();

    return $results[$data];
}

// biaya cabang() 
function biayaCabang($id_cabang, $data)
{
    $db = \Config\Database::connect();
    $id_cabang = is_array($id_cabang) ? 0 : $id_cabang;
    $builder = $db->table('setting_biaya');
    $builder->where('cabang_id', $id_cabang);
    $result = $builder->get()->getRowArray();
    return $result[$data] ?? '';
}

function countPengajuan(){
    $db = \Config\Database::connect();
    return $db->table('kasbon')->where('status', 'pengajuan')->countAllResults();
}
