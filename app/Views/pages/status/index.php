<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Status</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Status Pengerjaan</h6>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatabl" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Nama Cabang</th>
                            <th>Nama Status</th>
                            <th>Harga Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cabang as $c):  ?>
                            <?php $i = 1;
                            $total = 0; ?>
                            <?php foreach ($data as $row):  ?>
                                <?php if ($c['id_cabang'] == $row['id_cabang']):  ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td>
                                            <a href="/status/<?= $row['id_status']; ?>/edit" class="me-2 btn btn-sm btn-primary btn-edit"><i class="bx bx-pencil me-0"></i></a>
                                            <a href="/status/<?= $row['id_status']; ?>/delete" class="me-2 btn btn-sm btn-danger btn-delete" data-id-produk="<?= $row['id_status']; ?>"><i class="bx bx-trash me-0"></i></a>
                                        </td>
                                        <td><?= $row['nama_cabang']; ?></td>
                                        <td><?= $row['nama_status']; ?></td>
                                        <td>Rp <?= number_format($row['harga_status']); ?></td>
                                    </tr>
                                <?php $total += $row['harga_status'];
                                endif;  ?>
                            <?php endforeach;
                            $class = biayaCabang($c['id_cabang'], 'upah_mekanik') == $total ? '' : 'bg-danger' ?>
                            <tr>
                                <th colspan="2" class="text-end <?= $class; ?>">Upah Mekanik:</th>
                                <th class="<?= $class; ?>">Rp <?= number_format(biayaCabang($c['id_cabang'], 'upah_mekanik')); ?></th>
                                <th class="text-end <?= $class; ?>">Total</th>
                                <th class="<?= $class; ?>">Rp <?= number_format($total); ?></th>
                            </tr>
                        <?php endforeach;  ?>
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
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_status" class="form-label required">Nama Status</label>
                            <input type="text" name="nama_status" class="form-control" id="nama_status" placeholder="Nama Status">
                            <div class="invalid-feedback" id="invalid_nama_status"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="harga_status" class="form-label required">Harga Status</label>
                            <input type="text" name="harga_status" class="form-control" id="harga_status" placeholder="Harga Status">
                            <div class="invalid-feedback" id="invalid_harga_status"></div>
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
<?= $this->include('pages/status/script'); ?>
<?= $this->endSection(); ?>