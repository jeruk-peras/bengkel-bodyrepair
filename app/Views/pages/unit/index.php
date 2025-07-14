<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Mekanik Cabang</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Mekanik Cabang</h6>
                </div>
                <div class="ms-auto">
                    <a href="/unit/add" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah</a>
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
                            <th>Nomor SPP</th>
                            <th>Nama Customer</th>
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
                    <h6 class="mb-1">Informasi Customer</h6>
                    <p class="mb-2">Silakan lengkapi data customer bengkel pada form berikut.</p>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-md-6 col-6">
                            <label for="nama_customer" class="form-label required">Nama Customer</label>
                            <input type="text" name="nama_customer" class="form-control" id="nama_customer" placeholder="Nama Customer">
                            <div class="invalid-feedback" id="invalid_nama_customer"></div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-6">
                            <label for="no_handphone" class="form-label required">No Handphone</label>
                            <input type="text" name="no_handphone" class="form-control" id="no_handphone" placeholder="No Handphone">
                            <div class="invalid-feedback" id="invalid_no_handphone"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="alamat" class="form-label required">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat"></textarea>
                            <div class="invalid-feedback" id="invalid_alamat"></div>
                        </div>
                    </div>

                    <h6 class="mb-1">Informasi Unit</h6>
                    <p class="mb-2">Silakan lengkapi data Unit bengkel pada form berikut.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-md-3 col-6">
                            <label for="nomor_polisi" class="form-label required">Nomor Polisi</label>
                            <input type="text" name="nomor_polisi" class="form-control" id="nomor_polisi" placeholder="Nomor Polisi">
                            <div class="invalid-feedback" id="invalid_nomor_polisi"></div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-6">
                            <label for="model_unit" class="form-label required">Model Unit</label>
                            <input type="text" name="model_unit" class="form-control" id="model_unit" placeholder="Model Unit">
                            <div class="invalid-feedback" id="invalid_model_unit"></div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-6">
                            <label for="warna_unit" class="form-label required">Warna Unit</label>
                            <input type="text" name="warna_unit" class="form-control" id="warna_unit" placeholder="Warna Unit">
                            <div class="invalid-feedback" id="invalid_warna_unit"></div>
                        </div>

                        <div class="col-sm-6 col-md-3 col-6">
                            <label for="asuransi" class="form-label required">Asuransi</label>
                            <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Asuransi">
                            <div class="invalid-feedback" id="invalid_asuransi"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="nomor_mesin" class="form-label required">Nomor Mesin</label>
                            <input type="text" name="nomor_mesin" class="form-control" id="nomor_mesin" placeholder="Nomor Mesin">
                            <div class="invalid-feedback" id="invalid_nomor_mesin"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_rangka" class="form-label required">Nomor Rangka</label>
                            <input type="text" name="nomor_rangka" class="form-control" id="nomor_rangka" placeholder="Nomor Rangka">
                            <div class="invalid-feedback" id="invalid_nomor_rangka"></div>
                        </div>
                    </div>


                    <h6 class="mb-1">Informasi Pengerjaan</h6>
                    <p class="mb-2">Silakan lengkapi Informasi Pengerjaan Unit bengkel pada form berikut.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-12 col-md-4">
                            <label for="nomor_spp" class="form-label required">Nomor SPP</label>
                            <input type="text" name="nomor_spp" class="form-control" id="nomor_spp" value="<?= $nomor_spp ?? ''; ?>" placeholder="No SPP" readonly>
                            <div class="invalid-feedback" id="invalid_nomor_spp"></div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4">
                            <label for="tanggal_masuk" class="form-label required">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk" placeholder="Tanggal Masuk" value="<?= date('Y-m-d'); ?>" readonly>
                            <div class="invalid-feedback" id="invalid_tanggal_masuk"></div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4">
                            <label for="estimasi_selesai" class="form-label required">Estimasi Selesai</label>
                            <input type="date" name="estimasi_selesai" class="form-control" id="estimasi_selesai" placeholder="Estimasi Selesai">
                            <div class="invalid-feedback" id="invalid_estimasi_selesai"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="detail_pengerjaan" class="form-label required">Detail Pengerjaan</label>
                            <textarea name="detail_pengerjaan" class="form-control" rows="4" id="detail_pengerjaan"></textarea>
                            <div class="invalid-feedback" id="invalid_detail_pengerjaan"></div>
                        </div>
                    </div>

                    <h6 class="mb-1">Informasi Harga</h6>
                    <p class="mb-2">Silakan lengkapi Harga Pengerjaan Unit bengkel pada form berikut.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label for="harga_spp" class="form-label required">Harga SPP</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="harga_spp" class="form-control" id="harga_spp" placeholder="Harga SPP">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                            <div class="invalid-feedback" id="invalid_harga_spp"></div>
                        </div>
                        <div class="col-3 col-md-1">
                            <label for="diskon" class="form-label">Diskon</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" maxlength="3" name="diskon" class="form-control" value="<?= biayaCabang(session('selected_akses'), 'diskon'); ?>" style="padding-left: 0.75rem; padding-right: 1.90rem;" id="diskon">
                                <span class="position-absolute top-50 translate-middle-y" style="right: 15px !important; left: unset;">%</span>
                            </div>
                            <div class="invalid-feedback" id="invalid_diskon"></div>
                        </div>
                        <div class="col-9 col-md-5">
                            <label for="jumlah_diskon" class="form-label">Total Harga SPP</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="jumlah_diskon" class="form-control" id="jumlah_diskon" readonly placeholder="Total Harga">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                            <div class="invalid-feedback" id="invalid_jumlah_diskon"></div>
                        </div>
                        <div class="col-9 col-sm-8 col-md-4">
                            <label for="harga_panel" class="form-label">Harga Panel</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="harga_panel" class="form-control" id="harga_panel" value="<?= biayaCabang(session('selected_akses'), 'harga_panel'); ?>" placeholder="Harga Panel">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                        </div>
                        <div class="col-3 col-sm-4 col-md-1">
                            <label for="jumlah_panel" class="form-label">Panel</label>
                            <input type="text" class="form-control" readonly id="jumlah_panel">
                            <input type="hidden" name="jumlah_panel" readonly id="jumlah_panel_act">
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <label for="upah_mekanik" class="form-label">Upah Mekanik</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="upah_mekanik" class="form-control" id="upah_mekanik" value="<?= biayaCabang(session('selected_akses'), 'upah_mekanik'); ?>" placeholder="Upah Mekanik">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                        </div>

                        <div class="col-6 col-sm-6 col-md-4">
                            <label for="total_upah_mekanik" class="form-label">Total Upah Mekanik</label>
                            <div class="position-relative input-icon">
                                <input type="text" inputmode="numeric" name="total_upah_mekanik" class="form-control" id="total_upah_mekanik" readonly placeholder="Total Upah Mekanik">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
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

<!-- modal detail -->
<div class="modal fade" id="detail-data-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-sm-down modal-fullscreen-lg-down modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Unit <span class="text-primary fw-bolder" id="detail_nomor_spp"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                            <div class="p-2 rounded bg-light h-100">
                                <h6>Informasi Customer</h6>
                                <table class="w-100">
                                    <tr>
                                        <td>Nama Curtomer :</td>
                                        <th class="text-end" id="detail_nama_customer"></th>
                                    </tr>
                                    <tr>
                                        <td>No Handphone :</td>
                                        <th class="text-end" id="detail_no_handphone"></th>
                                    </tr>
                                    <tr>
                                        <td>Alamat :</td>
                                        <th class="text-end" id="detail_alamat"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                            <div class="p-2 rounded bg-light h-100">
                                <h6>Informasi Unit</h6>
                                <table class="w-100">
                                    <tr>
                                        <td>Nomor Polisi :</td>
                                        <th class="text-end" id="detail_nomor_polisi"></th>
                                    </tr>
                                    <tr>
                                        <td>Model :</td>
                                        <th class="text-end" id="detail_model_unit"></th>
                                    </tr>
                                    <tr>
                                        <td>Warna :</td>
                                        <th class="text-end" id="detail_warna_unit"></th>
                                    </tr>
                                    <tr>
                                        <td>Asuransi :</td>
                                        <th class="text-end" id="detail_asuransi"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                            <div class="p-2 rounded bg-light h-100">
                                <h6>Informasi Pekerjaan</h6>
                                <table class="w-100">
                                    <tr>
                                        <td>Tanggal Masuk :</td>
                                        <th class="text-end" id="detail_tanggal_masuk"></th>
                                    </tr>
                                    <tr>
                                        <td>Estimsai Selesai :</td>
                                        <th class="text-end" id="detail_estimasi_selesai"></th>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Panel :</td>
                                        <th class="text-end" id="detail_jumlah_panel"></th>
                                    </tr>
                                    <tr>
                                        <td>Status :</td>
                                        <th class="text-end">
                                            <span class="badge bg-primary" id="detail_status"></span>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                            <div class="p-2 rounded bg-light h-100">
                                <h6>Informasi Biaya</h6>
                                <table class="w-100">
                                    <tr>
                                        <td>Harga SPP :</td>
                                        <th class="text-end" id="detail_harga_spp"></th>
                                    </tr>
                                    <tr>
                                        <td>Diskon :</td>
                                        <th class="text-end" id="detail_diskon"></th>
                                    </tr>
                                    <tr>
                                        <td>Total Harga :</td>
                                        <th class="text-end" id="detail_jumlah_diskon"></th>
                                    </tr>
                                    <tr>
                                        <td>Upah Mekanik :</td>
                                        <th class="text-end" id="detail_total_upah_mekanik"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                            <div>Nomor Rangka : <span class="fw-bold" id="detail_nomor_rangka"></span></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                            <div>Nomor Mesin : <span class="fw-bold" id="detail_nomor_mesin"></span></div>
                        </div>
                        <div class="col-12 mt-2">
                            <div>Detail Pengerjaan :</div>
                            <div id="detail_detail_pengerjaan"></div>
                        </div>
                    </div>

                    <div class="mb-3" style="overflow-x: scroll;">
                        <div class="mb-3 fw-semibold">Progress Pekerjaan</div>
                        <div class="d-flex align-items-center justify-content-between position-relative" style="min-height:90px;" id="progres-unit">
                            <div class="position-absolute top-50 start-0 w-100 translate-middle-y" style="height:2px; background:#e9ecef; z-index:0;"></div>
                        </div>
                    </div>

                    <form action="" method="post" id="form-update-status" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row mb-3 rounded bg-light p-2">
                            <span class="mb-3 fw-semibold">Update Status</span>
                            <div class="mb-3 col-sm-8 col-md-8 col-8">
                                <label for="unit_status_harga_id" class="form-label required">Status</label>
                                <select class="form-select form-select-sm" name="unit_status_harga_id" id="unit_status_harga_id"></select>
                                <div class="invalid-feedback" id="invalid_unit_status_harga_id"></div>
                            </div>
                            <div class="mb-3 col-sm-4 col-md-4 col-4">
                                <label for="tanggal_update" class="form-label required">Tanggal Update</label>
                                <input type="date" name="tanggal_update" class="form-control form-control-sm" id="tanggal_update" value="<?= date('Y-m-d'); ?>">
                                <div class="invalid-feedback" id="invalid_tanggal_update"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="catatan" class="form-label required">Catatan</label>
                                <textarea type="date" name="catatan" class="form-control form-control-sm" id="catatan"></textarea>
                                <div class="invalid-feedback" id="invalid_catatan"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="gambar_status" class="form-label required">Upload Foto</label>
                                <input type="file" name="gambar_status" accept="image/*;capture=camera"" class=" form-control form-control-sm" id="gambar_status">
                                <div class="invalid-feedback" id="invalid_gambar_status"></div>
                            </div>
                            <div class="mb-2 col-12 text-end">
                                <button type="submit" class="btn btn-primary" id="btn-update">Update Status</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="table-responsive p-0">
                            <div class="fw-semibold mb-2">Penggunaan Material</div>
                            <table class="table mt-2 align-middle rounded mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Material</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Penggunaan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="material-unit"></tbody>
                            </table>
                        </div>
                        <div class="mb-2 mt-3 text-end">
                            <button class="btn btn-primary" data-bs-target="#modal-material-data" data-bs-toggle="modal"><i class="bx bx-plus me-0"></i> Tambah</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Riwayat Aktivitas</div>
                        <div class="list-group list-group-flush" id="riwayat-unit" style="max-height: 300px;overflow-y: scroll;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" data-href="" class="btn btn-primary" id="btn-selesai">Unit Selesai</button>
            </div>
        </div>
    </div>
</div>

<!-- modal pemakaian produk -->
<div class="modal fade" id="modal-material-data" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-sm-down modal-fullscreen-lg-down modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Penggunaan Material</h1>
                <button type="button" id="close-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-add-material">
                    <?= csrf_field(); ?>
                    <div class="row p-2">
                        <div class="mb-3 col-sm-8 col-md-8 col-8">
                            <label for="mekanik_id" class="form-label required">Mekanik</label>
                            <select class="form-select form-select-sm" name="mekanik_id" id="mekanik_id" required></select>
                        </div>
                        <div class="mb-3 col-sm-4 col-md-4 col-4">
                            <label for="tanggal" class="form-label required">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control form-control-sm" id="tanggal" required value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="row p-2" id="row-material">
                        <div class="mb-3 col-sm-12 col-md-12 col-lg-4 col-12">
                            <label class="form-label required">Material</label>
                            <select class="form-select form-select-sm select-material" name="material_id[]" id="material_id" required></select>
                        </div>
                        <div class="mb-3 col-sm-6 col-md-4 col-lg-2 col-6">
                            <label class="form-label required">Harga</label>
                            <div class="position-relative input-icon">
                                <input type="text" name="harga[]" class="form-control form-control-sm harga-material" readonly placeholder="xxxxxx">
                                <span class="position-absolute top-50 translate-middle-y">Rp </span>
                            </div>
                        </div>
                        <div class="mb-3 col-sm-6 col-md-3 col-lg-2 col-6">
                            <label class="form-label required">Jumlah</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y stok-material"></span>
                                <input type="text" inputmode="numeric" name="jumlah[]" class="form-control form-control-sm" id="jumlah" required style="padding-left: 2.5rem; padding-right: 1.90rem;">
                                <span class="position-absolute top-50 translate-middle-y satuan-material" style="right: 15px !important; left: unset;"></span>
                            </div>
                            <div class="form-text text-danger" id="invalid_jumlah"></div>
                        </div>
                        <div class="mb-3 col-sm-10 col-md-4 col-lg-3 col-10">
                            <label class="form-label required">Detail Jumlah</label>
                            <input type="text" name="detail_jumlah[]" class="form-control form-control-sm" id="detail_jumlah" required>
                        </div>
                        <div class="mb-3 col align-self-end">
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

<!-- modal gambar unit -->
 <div class="modal fade" id="modal-gambar-unit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary fw-bolder" id="nama-riwayat"></h1>
                <button type="button" id="close-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" id="gambar-unit" class="img-fluid" alt="Gambar Unit" style="max-height: 500px; max-width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('pages/unit/script'); ?>
<?= $this->endSection(); ?>