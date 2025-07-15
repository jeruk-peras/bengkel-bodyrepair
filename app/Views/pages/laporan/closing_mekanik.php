<?php $this->extend('layout/index');  ?>
<?php $this->section('content');  ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Closing Mekanik</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Laporan Closing Mekanik</h6>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle" rowspan="3">No</th>
                            <th class="align-middle" rowspan="3">Cabang</th>
                            <th class="align-middle" rowspan="3">Nomor SPP</th>
                            <th class="align-middle" rowspan="3">Nomor Polisi</th>
                            <th class="align-middle" rowspan="3">Model/Warna</th>
                            <th class="align-middle" rowspan="3">Upah Mekanik</th>
                            <th class="align-middle" rowspan="3">JML Panel</th>
                            <th class="text-center" colspan="<?= count($status) ?>">STATUS</th>
                        </tr>
                        <!-- status -->
                        <tr>
                            <?php foreach ($status as $row):  ?>
                                <th class="text-center" data-pp="<?= $harga_status_total[$row['nama_status']]; ?>"><?= $row['nama_status']; ?></th>
                            <?php endforeach;  ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($units as $row):  ?>
                            <tr>
                                <td><?= $row['cabang_id']; ?></td>
                                <td><?= $row['cabang_id']; ?></td>
                                <td><?= $row['nomor_spp']; ?></td>
                                <td><?= $row['nomor_polisi']; ?></td>
                                <td><?= $row['model_unit'] . '/' . $row['warna_unit']; ?></td>
                                <td>Rp <?= number_format($row['total_upah_mekanik']); ?></td>
                                <td class="text-center"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $row['jumlah_panel']; ?>"><?= round($row['jumlah_panel'], 2) ?></span></td>
                                <?php foreach ($row['status'] as $s):  ?>
                                    <td class="text-end"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $s['harga_status'] ?> * jml panel">Rp <?= number_format($s['total_harga_status']); ?></span></td>
                                <?php endforeach  ?>
                            </tr>
                        <?php endforeach  ?>
                        <tr>
                            <th class="text-end" colspan="7">TOTAL</th>
                            <?php foreach ($status as $r):  ?>
                                <th class="text-end">Rp <?= number_format($harga_status_total[$r['nama_status']]); ?></th>
                            <?php endforeach;  ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection();  ?>