<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Material</li>
                    <li class="breadcrumb-item active">Material Keluar</li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Unit</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <label>Filter : </label>
            <button class="btn btn-sm btn-outline-primary btn-filter active" data-f="1">Data Unit Berjalan</button>
            <button class="btn btn-sm btn-outline-primary btn-filter" data-f="0">Data Unit Closing</button>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Unit</h6>
                </div>
                <div class="ms-auto">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-5 py-1 active" data-bs-toggle="pill" href="#daftar-unit" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Daftar Unit</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-5 py-1" data-bs-toggle="pill" href="#daftar-material" id="tab-material" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Daftar Material</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="daftar-unit" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" data-filter="1" id="datatable" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>#</th>
                                    <th>Cabang</th>
                                    <th>Nomor SPP</th>
                                    <th>Nama SO</th>
                                    <th>Nomor Polisi</th>
                                    <th>Model/Warna</th>
                                    <th>Asuransi</th>
                                    <th>Taggal Masuk</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="daftar-material" role="tabpanel">
                    <div class="table-responsive" id="data-material"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal pemakaian produk -->
<div class="modal fade" id="modal-material-data" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-sm-down modal-fullscreen-lg-down modal-fullscreen-md-down">
        <div class="modal-content" style="height: 100vh;">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Penggunaan Material</h1>
                <button type="button" id="close-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-add-material">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3 col-sm-4 col-md-4 col-4">
                            <label for="tanggal" class="form-label required">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control form-control-sm" id="tanggal" required value="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="mb-3 col-sm-8 col-md-8 col-8">
                            <label for="mekanik_id" class="form-label required">Mekanik</label>
                            <select class="form-select form-select-sm" name="mekanik_id" id="mekanik_id" required></select>
                        </div>
                    </div>

                    <div class="row row-material" id="row-material">
                        <div class="col-sm-12 col-md-12 col-lg-5 col-12" style="padding-right: 5px !important;">
                            <label for="material_id" class="form-label required">Material</label>
                            <select class="form-select form-select-sm select-material" name="material_id[]" data-placeholder="Material" id="material_id" required></select>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-2 col-6" style="padding: 0 5px 0 5px !important;">
                            <label class="form-label required">Harga</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y">Rp</span>
                                <input type="text" name="harga[]" class="form-control form-control-sm harga-material" readonly placeholder="xxxxxx" style="padding-left: 2.5rem; padding-right: 1.90rem;">
                                <span class="position-absolute top-50 translate-middle-y satuan-material" style="right: 15px !important; left: unset;"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 col-6" style="padding: 0 5px 0 5px !important;">
                            <label for="jumlah" class="form-label required">Jumlah</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="jumlah[]" class="form-control form-control-sm" id="jumlah" required style="padding-left: 0.5rem; padding-right: 3rem;">
                                <span class="position-absolute top-50 translate-middle-y stok-material" style="right: 10px !important; left: unset;"></span>
                            </div>
                            <div class="form-text text-danger" id="invalid_jumlah"></div>
                        </div>
                        <div class="col-sm-10 col-md-4 col-lg-2 col-10" style="padding: 0 5px 0 5px !important;">
                            <label class="form-label required">Total Jumlah</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y">Rp</span>
                                <input type="text" class="form-control form-control-sm" id="display_total_harga" required readonly style="padding-left: 2.5rem;">
                                <input type="hidden" name="total_harga[]" id="total_harga">
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-4 col-lg-1 col-1" style="padding-left: 5px !important;">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn w-100 btn-primary btn-sm" id="btn-add-row">+</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn-material">Tambah Material</button>
            </div>
        </div>
    </div>
</div>

<!-- modal detail -->
<div class="modal fade" id="modal-material" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-sm-down modal-fullscreen-lg-down modal-fullscreen-md-down">
        <div class="modal-content" style="height: 100vh;">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Penggunaan Material</h1>
                <button type="button" id="close-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-2">
                    <div class="table-responsive p-0">
                        <table class="table align-middle rounded mb-0" id="data-material-unit">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Material</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="material-unit"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layout/tomselect'); ?>
<?= $this->include('pages/material_keluar/script'); ?>
<?= $this->endSection(); ?>