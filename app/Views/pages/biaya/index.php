<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Setting Biaya</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Setting Biaya</h6>
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
                            <th>No</th>
                            <th>#</th>
                            <th>Nama Cabang</th>
                            <th>Diskon</th>
                            <th>Harga /panel</th>
                            <th>Upah Mekanik</th>
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
                        <div class="invalid-feedback" id="invalid_cabang_id"></div>
                        <div class="col-md-4">
                            <label for="diskon" class="form-label required">Diskon</label>
                            <input type="text" name="diskon" class="form-control" id="diskon" placeholder="Diskon">
                            <div class="invalid-feedback" id="invalid_diskon"></div>
                            <div class="form-text">*untuk diskon masukan angka saja, jangan sertakan %</div>
                        </div>
                        <div class="col-md-4">
                            <label for="harga_panel" class="form-label required">Harga /panel</label>
                            <input type="text" name="harga_panel" class="form-control" id="harga_panel" placeholder="Harga /panel">
                            <div class="invalid-feedback" id="invalid_harga_panel"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="upah_mekanik" class="form-label required">Upah Mekanik</label>
                            <input type="text" name="upah_mekanik" class="form-control" id="upah_mekanik" placeholder="Upah Mekanik">
                            <div class="invalid-feedback" id="invalid_upah_mekanik"></div>
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
<?= $this->include('pages/biaya/script'); ?>
<?= $this->endSection(); ?>
