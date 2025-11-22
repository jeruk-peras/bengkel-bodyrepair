<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="http://localhost:8800/dashboard"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Gaji Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Gaji</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="/gaji-karyawan" class="btn btn-sm btn-primary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="periode" class="form-label">Periode</label>
                    <input type="text" class="form-control" id="periode" readonly="" disabled="" value="<?= $detailgaji['periode']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="text" class="form-control" id="tanggal" readonly="" disabled="" value="<?= $detailgaji['tanggal']; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div>
                </div>
                <div class="ms-auto">
                    <a href="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/print" target="_blank" class="btn btn-sm btn-primary"><i class="bx bx-printer"></i> Print Data</a>
                    <a href="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/export" class="btn btn-sm btn-primary"><i class="bx bx-export"></i> Export Data</a>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-import"></i> Import Data</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                    <thead class="table-light">
                        <tr class="text-uppercase align-middle">
                            <th rowspan="2">No</th>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Cabang</th>
                            <th rowspan="2">NIP</th>
                            <th rowspan="2">Nama Lengkap</th>
                            <th class="text-center" colspan="<?= count($komponen['pendapatan']); ?>">PENDAPATAN</th>
                            <th class="text-center border-start" colspan="<?= count($komponen['potongan']); ?>">potongan</th>
                        </tr>
                        <tr>
                            <?php foreach ($komponen['pendapatan'] as $k): ?>
                                <th><?= $k; ?></th>
                            <?php endforeach; ?>
                            <?php foreach ($komponen['potongan'] as $k): ?>
                                <th><?= $k; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = '1';
                        foreach ($karyawan as $k): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><a href="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/<?= $k['id_karyawan']; ?>/printgaji" target="_blank" class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Print Data"><i class="bx bx-printer me-0"></i></a></td>
                                <td><?= $k['cabang']; ?></td>
                                <td><?= $k['nip']; ?></td>
                                <td><?= $k['nama_lengkap']; ?><br><small><?= $k['jabatan']; ?></small></td>
                                <?php foreach ($k['pendapatan'] as $pen): ?>
                                    <td class="text-end"><?= $pen > 0 ? "Rp" . number_format($pen) : '-'; ?></td>
                                <?php endforeach; ?>
                                <?php foreach ($k['potongan'] as $pot): ?>
                                    <td class="text-end"><?= $pot > 0 ? "Rp" . number_format($pot) : '-'; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="form-data-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/import" method="post" id="form-data" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="file_excel" class="form-label required">Import Data</label>
                            <input type="file" name="file_excel" class="form-control" id="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" placeholder="file_excel">
                            <div class="invalid-feedback" id="invalid_file_excel"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>