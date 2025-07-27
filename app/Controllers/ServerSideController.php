<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\AsuransiModel;
use App\Models\CabangModel;
use App\Models\JenisModel;
use App\Models\MaterialMasukDetailModel;
use App\Models\MaterialModel;
use App\Models\MekanikModel;
use App\Models\SatuanModel;
use App\Models\UnitMaterialModel;
use App\Models\UnitStatusHargaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
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

    public function asuransi()
    {
        $table = 'asuransi';
        $primaryKey = 'id_asuransi';
        $columns = ['id_asuransi', 'nama_asuransi'];
        $orderableColumns = ['nama_asuransi'];
        $searchableColumns = ['nama_asuransi'];
        $defaultOrder = ['nama_asuransi', 'ASC'];

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
                htmlspecialchars($row['id_asuransi']),
                htmlspecialchars($row['nama_asuransi']),
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

    public function fetchAsuransi()
    {
        $modelAsuransi = new AsuransiModel();
        try {
            $data = $modelAsuransi->select('id_asuransi, nama_asuransi')->findAll();
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

        $where = [];
        if (session('user_type') == 'admin' && session('role') == 'Admin') {
            $where = [
                'role IN' => ['Admin Cabang']
            ];
        }

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->getData($columns, $orderableColumns, $searchableColumns, $defaultOrder, [], $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, [], $where);
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
        $columns = ['setting_biaya.id_setting_biaya', 'setting_biaya.diskon', 'setting_biaya.harga_panel', 'setting_biaya.upah_mekanik', 'setting_biaya.sharing', 'cabang.nama_cabang'];
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
                htmlspecialchars($row['sharing'] . '%'),
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

    public function unit()
    {
        $table = 'unit';
        $primaryKey = 'id_unit';
        $columns = ['unit.id_unit', 'unit.nama_sa', 'unit.nomor_spp', 'unit.nomor_polisi', 'unit.model_unit', 'unit.warna_unit', 'asuransi.nama_asuransi', 'unit.tanggal_masuk', 'unit.estimasi_selesai', 'unit.status', 'cabang.nama_cabang'];
        $orderableColumns = ['unit.nama_sa', 'unit.nomor_spp', 'unit.nomor_polisi', 'unit.model_unit', 'unit.warna_unit', 'asuransi.nama_asuransi', 'unit.tanggal_masuk', 'unit.estimasi_selesai', 'unit.status'];
        $searchableColumns = ['unit.nama_sa', 'unit.nomor_spp', 'unit.nomor_polisi', 'unit.model_unit', 'unit.warna_unit', 'asuransi.nama_asuransi', 'unit.tanggal_masuk', 'unit.estimasi_selesai', 'unit.status'];
        $defaultOrder = ['unit.tanggal_masuk', 'DESC'];

        $join = [
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = unit.cabang_id',
                'type' => ''
            ],
            [
                'table' => 'asuransi',
                'on' => 'asuransi.id_asuransi = unit.asuransi_id',
                'type' => ''
            ]
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'unit.cabang_id IN' => session('selected_akses')
            ];
        } else {
            $where = [
                'unit.cabang_id IN' => [session('selected_akses')]
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
                htmlspecialchars($row['id_unit']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nomor_spp']),
                htmlspecialchars($row['nama_sa']),
                htmlspecialchars($row['nomor_polisi']),
                htmlspecialchars($row['model_unit'] . '/' . $row['warna_unit']),
                htmlspecialchars($row['nama_asuransi']),
                htmlspecialchars(date_format(date_create($row['tanggal_masuk']), "d M Y")),
                htmlspecialchars(date_format(date_create($row['estimasi_selesai']), "d M Y")),
                ($row['status'] ? '<span class="badge bg-success">Selesai</span>' : '<span class="badge bg-primary">Sedang Proses</span>'),
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

    public function fetchMaterial(int $id_cabang = 0)
    {
        // set id cabang
        $id_cabang = session('selected_akses');

        $modelMaterial = new MaterialModel();
        try {
            $data = $modelMaterial
                ->select('material.id_material, material.nama_material, material.merek, material.harga, material.stok, material.cabang_id, satuan.nama_satuan')
                ->join('satuan', 'satuan.id_satuan = material.satuan_id', 'LEFT')
                ->where('material.cabang_id', $id_cabang)->findAll();

            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchMekanik(int $id_cabang = 0)
    {
        // set id cabang
        $id_cabang = session('selected_akses');

        $model = new MekanikModel();
        try {
            $data = $model->where('cabang_id', $id_cabang)->findAll();

            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchStatusUnit(int $id)
    {
        $modelStatus = new UnitStatusHargaModel();
        try {
            $sub = $this->db->table('unit_status')
                ->select('unit_status_harga_id')
                ->where('unit_id', $id)
                ->get()
                ->getResultArray();

            // hendla jika sub kosong maka kembalikan ''
            $sub = (empty($sub) ? [0 => ['unit_status_harga_id' => 0]] : $sub);

            $ids = array_column($sub, 'unit_status_harga_id');

            $data = $modelStatus
                ->select('id_unit_status_harga, nama_status')
                ->where('unit_status_harga.unit_id', $id)
                ->whereNotIn('unit_status_harga.id_unit_status_harga', $ids)
                ->orderBy('unit_status_harga.urutan', 'ASC')
                ->findAll();

            return ResponseJSONCollection::success($data, 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function fetchProsesStatusUnit(int $id)
    {
        $modelStatus = new UnitStatusHargaModel();
        try {
            $data = $modelStatus->select('unit_status_harga.id_unit_status_harga, unit_status_harga.nama_status, unit_status.*')
                ->join('unit_status', 'unit_status.unit_status_harga_id = unit_status_harga.id_unit_status_harga', 'LEFT')
                ->where('unit_status_harga.unit_id', $id)
                ->orderBy('unit_status_harga.id_unit_status_harga', 'ASC')
                ->findAll();

            $unit = $this->db->table('unit')->where('id_unit', $id)->get()->getRowArray();

            $html =
                '<div class="position-absolute top-50 start-0 w-100 translate-middle-y" style="height:2px; background:#e9ecef; z-index:0;"></div>
                <div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                    <div class="rounded-circle bg-success text-white mx-auto mb-1" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                        <i class="bx bx-check" style="font-size:1.2rem;"></i>
                    </div>
                    <div class="fw-semibold">Unit Masuk</div>
                    <div class="small text-secondary">' . date_format(date_create($unit['tanggal_masuk']), "d M Y") . '</div>
                </div>';

            $i = 0;
            $j = 1;
            foreach ($data as $row) {

                $active = $data[$i + 1]['tanggal_update'] ?? '';
                $active2 = $data[$i + 2]['tanggal_update'] ?? '';

                if ($row['tanggal_update'] == '') {
                    $html .=
                        '<div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                            <div class="rounded-circle bg-light text-secondary mx-auto mb-1 border" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                <span class="fw-bold">' . ($j + 1) . '</span>
                            </div>
                            <div class="fw-semibold">' . $row['nama_status'] . '</div>
                            <div class="small text-secondary">Menunggu</div>
                        </div>';
                } elseif ($active == '' && $active2 == '' && $unit['status'] == 0) {
                    $html .=
                        '<div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                            <div class="rounded-circle bg-primary text-white mx-auto mb-1" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                <i class="bx bx-loader-alt bx-spin" style="font-size:1.2rem;"></i>
                            </div>
                            <div class="fw-semibold">' . $row['nama_status'] . '</div>
                            <div class="small text-secondary">Sedang Proses</div>
                        </div>';
                } else {
                    $html .=
                        '<div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                            <div class="rounded-circle bg-success text-white mx-auto mb-1" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                <i class="bx bx-check" style="font-size:1.2rem;"></i>
                            </div>
                            <div class="fw-semibold">' . $row['nama_status'] . '</div>
                            <div class="small text-secondary">' . date_format(date_create($row['tanggal_update']), "d M Y") . '</div>
                        </div>';
                }
                $i++;
                $j++;
            }

            if ($unit['status'] == 0) {
                $html .=
                    '<div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                        <div class="rounded-circle bg-light text-secondary mx-auto mb-1 border" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                            <span class="fw-bold">' . ($j + 1) . '</span>
                        </div>
                        <div class="fw-semibold">Selesai</div>
                        <div class="small text-secondary">Menunggu</div>
                    </div>';
            } else {

                $html .=
                    '<div class="text-center position-relative" style="z-index:1; width:12%; min-width: 100px;">
                        <div class="rounded-circle bg-success text-white mx-auto mb-1" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                            <i class="bx bx-check" style="font-size:1.2rem;"></i>
                        </div>
                        <div class="fw-semibold">Selesai</div>
                        <div class="small text-secondary">' . date_format(date_create($unit['updated_at']), "d M Y") . '</div>
                    </div>';
            }



            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
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
                ->findAll();

            $html = '';

            $i = 1;
            foreach ($data as $row) {
                $html .=
                    '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $row['nama_jenis'] . '</td>
                        <td>' . $row['nama_material'] . '</td>
                        <td>' . $row['jumlah'] . '</td>
                        <td>' . $row['nama_satuan'] . '</td>
                        <td>' . $row['tanggal'] . '</td>
                    </tr>';
            }


            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    // fetch riwayat unit
    public function fetchRiwayatUnit(int $id)
    {
        try {
            // buat query ke table unit_material lalu join ke mekanik
            $material = $this->db->table('unit_material')
                ->select('unit_material.*, material.nama_material, material.stok, mekanik.nama_mekanik')
                ->join('material', 'material.id_material = unit_material.material_id', 'left')
                ->join('mekanik', 'mekanik.id_mekanik = unit_material.mekanik_id', 'left')
                ->where('unit_material.unit_id', $id)
                ->get()->getResultArray();

            $status = $this->db->table('unit_status')
                ->select('unit_status.*, unit_status_harga.nama_status, unit_status_harga.harga_status')
                ->join('unit_status_harga', 'unit_status_harga.id_unit_status_harga = unit_status.unit_status_harga_id', 'left')
                ->where('unit_status.unit_id', $id)
                ->orderBy('unit_status.id_unit_status', 'DESC')
                ->get()->getResultArray();


            $data = [];
            foreach ($material as $row) {
                $data[] = [
                    'tanggal' => date_format(date_create($row['tanggal']), "d M Y H:i"),
                    'nama_riwayat' => 'Material ditambahkan',
                    'catatan' => $row['nama_material'] . ' (jml ' . $row['jumlah'] . ')',
                    'by' => $row['nama_mekanik'],
                    'data' => 'material',
                ];
            }

            foreach ($status as $row) {
                $data[] = [
                    'tanggal' => date_format(date_create($row['tanggal_update']), "d M Y H:i"),
                    'nama_riwayat' => 'Status diubah ke ' . $row['nama_status'],
                    'catatan' => $row['catatan'],
                    'by' => $row['by_user'],
                    'data' => 'status',
                    'gambar' => '/assets/images/status/' . $row['gambar_status'],
                ];
            }

            // data unit
            $unit = $this->db->table('unit')->where('id_unit', $id)->get()->getRowArray();
            $data[] = [
                'tanggal' => $unit['tanggal_masuk'],
                'nama_riwayat' => 'Unit masuk',
                'catatan' => $unit['nomor_polisi'] . ' (' . $unit['model_unit'] . ')',
                'by' => '-',
                'data' => 'material',
            ];

            // jika unit sudah selesai, tambahkan riwayat selesai
            if ($unit['status'] == 1) {
                $data[] = [
                    'tanggal' => $unit['updated_at'],
                    'nama_riwayat' => 'Unit selesai',
                    'catatan' => 'Unit telah selesai',
                    'by' => $unit['nama_customer'],
                    'data' => 'material',
                ];
            }

            // urutkan data berdasarkan tanggal
            usort($data, function ($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });

            $html = '';

            foreach ($data as $row) {

                // ubah format tanggal
                $row['tanggal'] = date_format(date_create($row['tanggal']), "d M Y H:i");
                if ($row['data'] == 'material') {
                    $html .=
                        '<div class="list-group-item d-flex align-items-start bg-light mb-2 rounded border-0">
                            <div class="me-3 mt-1">
                                <button class="btn btn-inverse-info">
                                    <i class="bx bx-file me-0" style="font-size:1.3rem;"></i>
                                </button>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">' . $row['nama_riwayat'] . '</div>
                                <div class="small">' . $row['catatan'] . '</div>
                                <div class="small text-secondary">Oleh: ' . $row['by'] . '</div>
                            </div>
                            <div class="text-end small text-secondary ms-2">' . $row['tanggal'] . '</div>
                        </div>';
                } elseif ($row['data'] == 'status') {
                    $html .=
                        '<div class="list-group-item d-flex align-items-start bg-light mb-2 rounded border-0">
                            <div class="me-3 mt-1">
                                <button class="btn btn-inverse-success" id="btn-gambar-unit" data-gambar="' . $row['gambar'] . '" data-riwayat="' . $row['nama_riwayat'] . '">
                                    <i class="bx bx-refresh me-0" style="font-size:1.3rem;"></i>
                                </button>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">' . $row['nama_riwayat'] . '</div>
                                <div class="small">' . $row['catatan'] . '</div>
                                <div class="small text-secondary">Oleh: ' . $row['by'] . '</div>
                            </div>
                            <div class="text-end small text-secondary ms-2">' . $row['tanggal'] . '</div>
                        </div>';
                }
            }

            return ResponseJSONCollection::success(['html' => $html, 'data' => $data], 'Berhasil fetch data', ResponseInterface::HTTP_OK);
        } catch (DatabaseException $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan sistem', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function epoxy()
    {
        $table = 'cetak';
        $primaryKey = 'id_cetak';
        $columns = ['cetak.id_cetak', 'cetak.unit_id', 'cabang.nama_cabang', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $orderableColumns = ['cetak.unit_id', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $searchableColumns = ['cetak.unit_id', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $defaultOrder = ['cetak.unit_id', 'ASC'];

        $join = [
            [
                'table' => 'unit',
                'on' => 'unit.id_unit = cetak.unit_id',
                'type' => ''
            ],
            [
                'table' => 'asuransi',
                'on' => 'asuransi.id_asuransi = unit.asuransi_id',
                'type' => ''
            ],
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = unit.cabang_id',
                'type' => ''
            ],
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'cabang.id_cabang IN' => session('selected_akses'),
                'cetak.kategori_cetak' => 'epoxy'
            ];
        } else {
            $where = [
                'cabang.id_cabang IN' => [session('selected_akses')],
                'cetak.kategori_cetak' => 'epoxy'
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
                htmlspecialchars($row['id_cetak']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nomor_spp']),
                htmlspecialchars($row['nomor_polisi']),
                htmlspecialchars($row['nama_asuransi']),
                htmlspecialchars($row['model_unit']),
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

    public function gandeng()
    {
        $table = 'cetak';
        $primaryKey = 'id_cetak';
        $columns = ['cetak.id_cetak', 'cetak.unit_id', 'cabang.nama_cabang', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $orderableColumns = ['cetak.unit_id', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $searchableColumns = ['cetak.unit_id', 'unit.nomor_polisi', 'unit.nomor_spp', 'unit.model_unit', 'asuransi.nama_asuransi'];
        $defaultOrder = ['cetak.unit_id', 'ASC'];

        $join = [
            [
                'table' => 'unit',
                'on' => 'unit.id_unit = cetak.unit_id',
                'type' => ''
            ],
            [
                'table' => 'asuransi',
                'on' => 'asuransi.id_asuransi = unit.asuransi_id',
                'type' => ''
            ],
            [
                'table' => 'cabang',
                'on' => 'cabang.id_cabang = unit.cabang_id',
                'type' => ''
            ],
        ];

        if (is_array(session('selected_akses'))) {
            $where = [
                'cabang.id_cabang IN' => session('selected_akses'),
                'cetak.kategori_cetak' => 'gandeng'
            ];
        } else {
            $where = [
                'cabang.id_cabang IN' => [session('selected_akses')],
                'cetak.kategori_cetak' => 'gandeng'
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
                htmlspecialchars($row['id_cetak']),
                htmlspecialchars($row['nama_cabang']),
                htmlspecialchars($row['nomor_spp']),
                htmlspecialchars($row['nomor_polisi']),
                htmlspecialchars($row['nama_asuransi']),
                htmlspecialchars($row['model_unit']),
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

    public function fetchNoSPP()
    {
        $id_cabang = is_array($this->id_cabang) ? $this->id_cabang : [$this->id_cabang];
        $data = $this->db->table('unit')
            ->select('unit.id_unit, unit.nomor_spp, unit.nomor_polisi, asuransi.nama_asuransi, unit.model_unit')
            ->join('asuransi', 'asuransi.id_asuransi = unit.asuransi_id')
            ->whereIn('unit.cabang_id', $id_cabang)
            ->get()->getResultArray();

        return ResponseJSONCollection::success($data, 'Data fetched successfully', ResponseInterface::HTTP_OK);
    }

    public function fetchCetakFoto(int $id)
    {
        try {
            $data = $this->db->table('cetak_gambar')->select('id_cetak_gambar, gambar')->where('cetak_id', $id)->get()->getResultArray();

            return ResponseJSONCollection::success(['url' => base_url('assets/images/epoxy/'), 'foto' => $data], 'Fetch Foto berhasil.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCetakFoto(int $id)
    {
        try {
            // cek apakah id_cetak_gambar ada dan hapus unlink gambar
            $cetakGambar = $this->db->table('cetak_gambar')->where('id_cetak_gambar', $id)->get()->getRowArray();
            if (!$cetakGambar) {
                return ResponseJSONCollection::error([], 'Foto tidak ditemukan.', ResponseInterface::HTTP_NOT_FOUND);
            }

            if (file_exists(FCPATH . 'assets/images/epoxy/' . $cetakGambar['gambar'])) {
                unlink(FCPATH . 'assets/images/epoxy/' . $cetakGambar['gambar']);
            } else {
                return ResponseJSONCollection::error([], 'Foto tidak ditemukan di server.', ResponseInterface::HTTP_NOT_FOUND);
            }

            $data = $this->db->table('cetak_gambar')->where('id_cetak_gambar', $id)->delete();

            return ResponseJSONCollection::success([], 'Delete Foto berhasil.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage()], 'Terjadi kesalahan server.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
