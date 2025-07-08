<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\CabangModel;
use App\Models\JenisModel;
use App\Models\MaterialMasukDetailModel;
use App\Models\SatuanModel;
use CodeIgniter\HTTP\ResponseInterface;

class ServerSideController extends BaseController
{
    public function cabang()
    {
        $table = 'cabang';
        $primaryKey = 'id_cabang';
        $columns = ['id_cabang', 'nama_cabang', 'lokasi_cabang', 'alamat_lengkap'];
        $orderableColumns = ['nama_cabang', 'lokasi_cabang', 'alamat_lengkap'];
        $searchableColumns = ['nama_cabang', 'lokasi_cabang', 'alamat_lengkap'];
        $defaultOrder = ['nama_cabang', 'ASC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_cabang']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['lokasi_cabang']),
                htmlspecialchars($row['alamat_lengkap']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function jenis()
    {
        $table = 'jenis';
        $primaryKey = 'id_jenis';
        $columns = ['id_jenis', 'nama_jenis'];
        $orderableColumns = ['nama_jenis'];
        $searchableColumns = ['nama_jenis'];
        $defaultOrder = ['nama_jenis', 'ASC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_jenis']),
                htmlspecialchars($row['nama_jenis']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function satuan()
    {
        $table = 'satuan';
        $primaryKey = 'id_satuan';
        $columns = ['id_satuan', 'nama_satuan'];
        $orderableColumns = ['nama_satuan'];
        $searchableColumns = ['nama_satuan'];
        $defaultOrder = ['nama_satuan', 'ASC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_satuan']),
                htmlspecialchars($row['nama_satuan']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function fetchCabang()
    {
        $modelCabang = new CabangModel();
        try {
            $data = $modelCabang->select('id_cabang, nama_cabang')->findAll();
            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchSatuan()
    {
        $modelSatuan = new SatuanModel();
        try {
            $data = $modelSatuan->select('id_satuan, nama_satuan')->findAll();
            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchJenis()
    {
        $modelJenis = new JenisModel();
        try {
            $data = $modelJenis->select('id_jenis, nama_jenis')->findAll();
            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function users()
    {
        $table = 'users';
        $primaryKey = 'id_user';
        $columns = ['id_user', 'nama_lengkap', 'no_handphone', 'alamat', 'username'];
        $orderableColumns = ['nama_lengkap', 'no_handphone', 'alamat', 'username'];
        $searchableColumns = ['nama_lengkap', 'no_handphone', 'alamat', 'username'];
        $defaultOrder = ['nama_lengkap', 'ASC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_user']),
                htmlspecialchars($row['nama_lengkap']),
                htmlspecialchars($row['no_handphone']),
                htmlspecialchars($row['alamat']),
                htmlspecialchars($row['username']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function admin()
    {
        $table = 'admin_cabang';
        $primaryKey = 'id_admin';
        $columns = ['admin_cabang.id_admin', 'admin_cabang.nama_lengkap', 'admin_cabang.no_handphone', 'admin_cabang.alamat', 'cabang.nama_cabang', 'admin_cabang.username'];
        $orderableColumns = ['admin_cabang.nama_lengkap', 'admin_cabang.no_handphone', 'admin_cabang.alamat', 'cabang.nama_cabang', 'admin_cabang.username'];
        $searchableColumns = ['admin_cabang.nama_lengkap', 'admin_cabang.no_handphone', 'admin_cabang.alamat', 'cabang.nama_cabang', 'admin_cabang.username'];
        $defaultOrder = ['admin_cabang.nama_lengkap', 'ASC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = admin_cabang.cabang_id',
                'type' => ''
            ]
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_admin']),
                htmlspecialchars($row['nama_lengkap']),
                htmlspecialchars($row['no_handphone']),
                htmlspecialchars($row['alamat']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['username']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function mekanik()
    {
        $table = 'mekanik';
        $primaryKey = 'id_mekanik';
        $columns = ['mekanik.id_mekanik', 'mekanik.nama_mekanik', 'mekanik.no_handphone', 'cabang.nama_cabang'];
        $orderableColumns = ['mekanik.nama_mekanik', 'mekanik.no_handphone'];
        $searchableColumns = ['mekanik.nama_mekanik', 'mekanik.no_handphone'];
        $defaultOrder = ['mekanik.nama_mekanik', 'ASC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = mekanik.cabang_id',
                'type' => ''
            ]
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'mekanik.cabang_id IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'mekanik.cabang_id IN' => [session('selected_akses')]
            ];
        }

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_mekanik']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nama_mekanik']),
                htmlspecialchars($row['no_handphone']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function status()
    {
        $table = 'status';
        $primaryKey = 'id_status';
        $columns = ['status.id_status', 'status.nama_status', 'status.harga_status', 'cabang.nama_cabang'];
        $orderableColumns = ['status.nama_status', 'status.harga_status'];
        $searchableColumns = ['status.nama_status', 'status.harga_status'];
        $defaultOrder = ['status.nama_status', 'ASC'];

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

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_status']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nama_status']),
                htmlspecialchars($row['harga_status']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function biaya()
    {
        $table = 'setting_biaya';
        $primaryKey = 'id_setting_biaya';
        $columns = ['setting_biaya.id_setting_biaya', 'setting_biaya.diskon', 'setting_biaya.harga_panel', 'setting_biaya.upah_mekanik', 'cabang.nama_cabang'];
        $orderableColumns = ['setting_biaya.diskon', 'setting_biaya.harga_panel', 'setting_biaya.upah_mekanik'];
        $searchableColumns = ['setting_biaya.diskon', 'setting_biaya.harga_panel', 'setting_biaya.upah_mekanik'];
        $defaultOrder = ['setting_biaya.diskon', 'ASC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = setting_biaya.cabang_id',
                'type' => ''
            ]
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'cabang.id_cabang IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'cabang.id_cabang IN' => [session('selected_akses')]
            ];
        }

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_setting_biaya']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['diskon'] . '%'),
                htmlspecialchars('Rp ' . number_format($row['harga_panel'])),
                htmlspecialchars('Rp ' . number_format($row['upah_mekanik'])),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function material()
    {
        $table = 'material';
        $primaryKey = 'id_material';
        $columns = ['material.id_material', 'material.nama_material', 'material.merek', 'material.harga', 'material.stok', 'cabang.nama_cabang', 'satuan.nama_satuan', 'jenis.nama_jenis'];
        $orderableColumns = ['material.nama_material', 'material.harga'];
        $searchableColumns = ['material.nama_material', 'material.harga'];
        $defaultOrder = ['material.nama_material', 'ASC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = material.cabang_id',
                'type' => ''
            ],
            [
                'table' => 'jenis',
                'on' => 'jenis.id_jenis = material.jenis_id',
                'type' => ''
            ],
            [
                'table' => 'satuan',
                'on' => 'satuan.id_satuan = material.satuan_id',
                'type' => ''
            ],
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'material.cabang_id IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'material.cabang_id IN' => [session('selected_akses')]
            ];
        }

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_material']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nama_jenis']),
                htmlspecialchars($row['nama_material']),
                htmlspecialchars($row['merek']),
                htmlspecialchars('Rp ' . number_format($row['harga'])),
                htmlspecialchars($row['stok']),
                htmlspecialchars($row['nama_satuan']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function materialMasuk()
    {
        $table = 'material_masuk';
        $primaryKey = 'id_material_masuk';
        $columns = ['material_masuk.id_material_masuk', 'material_masuk.tanggal', 'material_masuk.no_delivery', 'material_masuk.suplier', 'material_masuk.total_harga', 'material_masuk.catatan', 'material_masuk.status', 'cabang.nama_cabang'];
        $orderableColumns = ['material_masuk.tanggal', 'material_masuk.no_delivery', 'material_masuk.suplier', 'material_masuk.total_harga', 'material_masuk.catatan'];
        $searchableColumns = ['material_masuk.tanggal', 'material_masuk.no_delivery', 'material_masuk.suplier', 'material_masuk.total_harga', 'material_masuk.catatan'];
        $defaultOrder = ['material_masuk.tanggal', 'ASC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = material_masuk.cabang_id',
                'type' => ''
            ],
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'material_masuk.cabang_id IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'material_masuk.cabang_id IN' => [session('selected_akses')]
            ];
        }

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_material_masuk']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars(date_format(date_create($row['tanggal']), "d M Y H:i")),
                htmlspecialchars($row['no_delivery']),
                htmlspecialchars($row['suplier']),
                htmlspecialchars($row['id_material_masuk']),
                htmlspecialchars(number_format($row['total_harga'])),
                htmlspecialchars($row['catatan']),
                htmlspecialchars($row['status']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function itemMaterialMasuk()
    {
        $id = $this->request->getPost('id_material_masuk');

        $modelMaterialMasukDetail = new MaterialMasukDetailModel();
        $data = $modelMaterialMasukDetail
            ->select('material_masuk_detail.id_material_masuk_detail, material_masuk_detail.harga_masuk, material_masuk_detail.stok_masuk, material.nama_material, material.stok, satuan.nama_satuan, jenis.nama_jenis')
            ->join('material', 'material.id_material = material_masuk_detail.material_id', 'left')
            ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
            ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
            ->where('material_masuk_detail.material_masuk_id', $id)
            ->orderBy('material_masuk_detail.id_material_masuk_detail', 'DESC')
            ->findAll();

        $html = '';
        $no = 1;
        foreach ($data as $row) {
            $html .=
                '<tr>
                    <input type="hidden" name="id_material_masuk_detail[]" value="' . $row['id_material_masuk_detail'] . '">
                    <td>' . $no++ . '</td>
                    <td>' . $row['nama_jenis'] . '</td>
                    <td>' . $row['nama_material'] . '</td>
                    <td class="text-center">' . $row['stok'] . '</td>
                    <td>' . $row['nama_satuan'] . '</td>
                    <td>
                        <div class="input-group" style="width: 160px;"> 
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input type="number" name="harga_masuk[' . $row['id_material_masuk_detail'] . ']" value="' . $row['harga_masuk'] . '" class="form-control input-change" aria-describedby="basic-addon1">
                        </div>
                    </td>
                    <td><input type="number" name="stok_masuk[' . $row['id_material_masuk_detail'] . ']" class="form-control input-change" value="' . $row['stok_masuk'] . '" style="width: 110px;"></td>
                    <td>
                        <button  class="me-2 btn btn-sm btn-danger btn-delete-item" data-id="' . $row['id_material_masuk_detail'] . '"><i class="bx bx-trash me-0"></i></button>
                    </td>   
                </tr>';
        }

        return ResponseJSONCollection::success($html, 'Fecth item berhasil', ResponseInterface::HTTP_OK);
    }

    public function itemsMaterialMasuk()
    {
        $id = $this->request->getPost('id_material_masuk');

        $modelMaterialMasukDetail = new MaterialMasukDetailModel();
        $data = $modelMaterialMasukDetail
            ->select('material_masuk_detail.*, material.nama_material, material.harga, material.stok, satuan.nama_satuan, jenis.nama_jenis')
            ->join('material', 'material.id_material = material_masuk_detail.material_id', 'left')
            ->join('jenis', 'jenis.id_jenis = material.jenis_id', 'left')
            ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'left')
            ->where('material_masuk_detail.material_masuk_id', $id)
            ->findAll();

        $html = '';
        $no = 1;
        foreach ($data as $row) {
            $html .=
                '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $row['nama_jenis'] . '</td>
                    <td>' . $row['nama_material'] . '</td>
                    <td>' . $row['nama_satuan'] . '</td>
                    <td>Rp ' . number_format($row['harga'] - $row['harga_masuk']) . '</td>
                    <td>Rp ' . number_format($row['harga']) . '</td>
                    <td>' . $row['stok'] - $row['stok_masuk'] . '</td>
                    <td>' . $row['stok_masuk'] . '</td>
                    <td>' . $row['stok'] . '</td>
                </tr>';
        }

        return ResponseJSONCollection::success($html, 'Fecth item berhasil', ResponseInterface::HTTP_OK);
    }
}
