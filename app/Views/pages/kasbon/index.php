<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Kasbon Karyawan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Kasbon Karyawan</h6>
                </div>
                <div class="ms-auto">
                    <ul class="nav nav-pills flex-nowrap" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-3 py-1 active" data-bs-toggle="pill" href="#daftar-kasbon" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Daftar Kasbon</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-3 py-1" data-bs-toggle="pill" href="#daftar-pengajuan" id="tab-pengajuan" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Histori Pengajuan</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/kasbon/import" class="btn btn-sm btn-primary ms-2 px-3"><i class="bx bx-upload"></i> Import Pengajuan</a>
                        </li>
                        <?php if (session('role') == 'Finance' || session('user_type') == 'admin'):  ?>
                        <li>
                            <a href="/kasbon/pembayaran" class="btn btn-sm btn-primary ms-2 px-3"><i class="bx bx-bracket"></i> Tarik Penbayaran Kasbon</a>
                        </li>
                        <?php endif;  ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="daftar-kasbon" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>#</th>
                                    <th>Cabang</th>
                                    <th>Karyawan</th>
                                    <th>jabatan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="daftar-pengajuan" role="tabpanel">
                    <div class="table-responsive" id="data-pengajuan"></div>
                </div>
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
                        <div class="col-md-8">
                            <label for="nama_komponen_gaji" class="form-label required">Komponen Gaji</label>
                            <input type="text" name="nama_komponen_gaji" class="form-control" id="nama_komponen_gaji" placeholder="Komponen Gaji">
                            <div class="invalid-feedback" id="invalid_nama_komponen_gaji"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="jenis" class="form-label required">Jenis</label>
                            <select name="jenis" class="form-select" id="jenis">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="Pendapatan">Pendapatan</option>
                                <option value="Potongan">Potongan</option>
                            </select>
                            <div class="invalid-feedback" id="invalid_jenis"></div>
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
<?= $this->include('pages/kasbon/script'); ?>
<?= $this->endSection(); ?>