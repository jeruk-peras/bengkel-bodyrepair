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
                    <button class="btn btn-sm btn-primary" id="btn-modal-material" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah</button>
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
                            <th>Jenis</th>
                            <th>Nama Material</th>
                            <th>Merek</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Satuan</th>
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
                        <div class="col-md-12">
                            <label for="nama_material" class="form-label required">Nama Material</label>
                            <input type="text" name="nama_material" class="form-control" id="nama_material" placeholder="Nama Material">
                            <div class="invalid-feedback" id="invalid_nama_material"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="merek" class="form-label required">Merek Material</label>
                            <input type="text" name="merek" class="form-control" id="merek" placeholder="Merek Material">
                            <div class="invalid-feedback" id="invalid_merek"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="harga" class="form-label required">Harga</label>
                            <div class="position-relative input-icon">
                                <input type="tel" name="harga" class="form-control rupiah" id="harga" placeholder="Harga">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                            <div class="invalid-feedback" id="invalid_harga"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="stok" class="form-label required">Stok</label>
                            <input type="tel" name="stok" class="form-control" id="stok" placeholder="Stok">
                            <div class="invalid-feedback" id="invalid_stok"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="satuan_id" class="form-label required">Satuan Material</label>
                            <select name="satuan_id" class="form-select" data-placeholder="Satuan" id="satuan_id"></select>
                            <div class="invalid-feedback" id="invalid_satuan_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_id" class="form-label required">Jenis Material</label>
                            <select name="jenis_id" class="form-select" data-placeholder="Jenis" id="jenis_id"></select>
                            <div class="invalid-feedback" id="invalid_jenis_id"></div>
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
<?= $this->include('pages/material/script'); ?>
<?= $this->endSection(); ?>