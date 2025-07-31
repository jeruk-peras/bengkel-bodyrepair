<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\HTTP\ResponseInterface;

class TransferController extends BaseController
{
    private $title = 'Transfer Material';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'cabang' => $this->db->table('cabang')->get()->getResultArray(),
        ];
        return view('pages/transfer_material/index', $data);
    }

    public function previewMaterial()
    {
        $cabang_form = $this->request->getPost('form_cabang');

        try {
            // get data material
            $material = $this->db->table('material')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id')
                ->join('satuan', 'satuan.id_satuan = material.satuan_id')
                ->where('material.cabang_id', $cabang_form)->get()->getResultArray();

            $html = view('pages/transfer_material/side_transfer_material', ['material' => $material]);

            return ResponseJSONCollection::success(['html' => $html, 'material' => $material], 'Data berhasil di ambil', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi Kesalahan server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function transferMaterial()
    {
        $cabang_form = $this->request->getPost('form_cabang');
        $cabang_to = $this->request->getPost('to_cabang');

        try {
            // get data material
            $material = $this->db->table('material')
                ->join('jenis', 'jenis.id_jenis = material.jenis_id')
                ->join('satuan', 'satuan.id_satuan = material.satuan_id')
                ->where('material.cabang_id', $cabang_form)->get()->getResultArray();

            // buat array uttuk insert batch
            $data = [];

            foreach ($material as $row) {
                $data[] = [
                    'nama_material'  => $row['nama_material'],
                    'merek'          => $row['merek'],
                    'harga'          => $row['harga'],
                    'stok'           => 0,
                    'satuan_id'      => $row['satuan_id'],
                    'jenis_id'       => $row['jenis_id'],
                    'cabang_id'      => $cabang_to,
                ];
            }

            // simpan batch data
            $simpan = $this->db->table('material')->insertBatch($data);

            return ResponseJSONCollection::success(['material' => $data], 'Data berhasil ditransfer', ResponseInterface::HTTP_OK);
        } catch (\Throwable $e) {
            return ResponseJSONCollection::error([$e->getMessage(), $e->getLine()], 'Terjadi Kesalahan server', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
}
