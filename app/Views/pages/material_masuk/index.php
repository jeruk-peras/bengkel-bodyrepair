<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Material</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Material</h6>
                </div>
                <div class="ms-auto">
                    <!-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah</button> -->
                    <a href="<?= base_url('material-masuk/add'); ?>" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Cabang</th>
                            <th>Tanggal</th>
                            <th>No Delivery</th>
                            <th>Suplier</th>
                            <th>Rincian</th>
                            <th>Total Harga</th>
                            <th>Catatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                            <label for="tanggal" class="form-label required">Tanggal Masuk</label>
                            <input type="datetime-local" name="tanggal" class="form-control" id="tanggal" placeholder="Tanggal Masuk" value="<?= date('Y-m-d\TH:i'); ?>">
                            <div class="invalid-feedback" id="invalid_tanggal"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_delivery" class="form-label required">Nomor Delivery</label>
                            <input type="text" name="no_delivery" class="form-control" id="no_delivery" placeholder="Nomor Delivery">
                            <div class="invalid-feedback" id="invalid_no_delivery"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="suplier" class="form-label required">Suplier</label>
                            <input type="text" name="suplier" class="form-control" id="suplier" placeholder="Suplier">
                            <div class="invalid-feedback" id="invalid_suplier"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="total_harga" class="form-label required">Total Harga</label>
                            <input type="tel" name="total_harga" class="form-control" id="total_harga" placeholder="Total Harga">
                            <div class="invalid-feedback" id="invalid_total_harga"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" id="catatan"></textarea>
                            <div class="invalid-feedback" id="invalid_harga"></div>
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

<!-- Modal -->
<div class="modal fade" id="items-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Jenis</th>
                                <th rowspan="2" class="align-middle">Nama Material</th>
                                <th rowspan="2" class="align-middle">Satuan</th>
                                <th colspan="2" class="text-center">Harga</th>
                                <th colspan="3" class="text-center">Stok</th>
                            </tr>
                            <tr>
                                <th>Awal</th>
                                <th>Masuk</th>
                                <th>Awal</th>
                                <th>Masuk</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="data-item"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('pages/material_masuk/script'); ?>
<?= $this->endSection(); ?>