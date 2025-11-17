<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Satuan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Satuan</h6>
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
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>No KTP</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Cabang</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Tanggal Mulai Kerja</th>
                            <th>Status</th>
                            <th>No HP</th>
                            <th>Email</th>
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
                            <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap">
                            <div class="invalid-feedback" id="invalid_nama_lengkap"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_ktp" class="form-label required">Nomor KTP/NIK</label>
                            <input type="text" inputmode="numeric" maxlength="16" name="no_ktp" class="form-control" id="no_ktp" placeholder="Nomor KTP/NIK">
                            <div class="invalid-feedback" id="invalid_no_ktp"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir">
                            <div class="invalid-feedback" id="invalid_tempat_lahir"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" placeholder="Tanggal Lahir">
                            <div class="invalid-feedback" id="invalid_tanggal_lahir"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" id="jenis_kelamin">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <div class="invalid-feedback" id="invalid_jenis_kelamin"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="alamat" class="form-label required">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat"></textarea>
                            <div class="invalid-feedback" id="invalid_alamat"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <input type="text" inputmode="numeric" maxlength="16" name="no_hp" class="form-control" id="no_hp" placeholder="Nomor Handphone">
                            <div class="invalid-feedback" id="invalid_no_hp"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                            <div class="invalid-feedback" id="invalid_email"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="nip" class="form-label required">NIP</label>
                            <input type="text" name="nip" class="form-control" id="nip" placeholder="NIP">
                            <div class="invalid-feedback" id="invalid_nip"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="jabatan" class="form-label required">Jabatan</label>
                            <select name="jabatan" class="form-select" id="jabatan">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="Admin">Admin</option>
                                <option value="Group Head">Group Head</option>
                                <option value="Mekanik">Mekanik</option>
                            </select>
                            <div class="invalid-feedback" id="invalid_jabatan"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="dapartemen" class="form-label required">Dapartemen</label>
                            <input type="text" name="dapartemen" class="form-control" id="dapartemen" placeholder="Dapartemen">
                            <div class="invalid-feedback" id="invalid_dapartemen"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_mulai_kerja" class="form-label">Mulai Kerja</label>
                            <input type="date" name="tanggal_mulai_kerja" class="form-control" id="tanggal_mulai_kerja" placeholder="Mulai Kerja">
                            <div class="invalid-feedback" id="invalid_tanggal_mulai_kerja"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label required">Status Keryawan</label>
                             <select name="status" class="form-select" id="status">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                            <div class="invalid-feedback" id="invalid_status"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="cabang_id" class="form-label required">Cabang</label>
                            <select name="cabang_id" class="form-select" id="cabang_id"></select>
                            <div class="invalid-feedback" id="invalid_cabang_id"></div>
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
<?= $this->include('layout/tomselect'); ?>
<?= $this->include('pages/karyawan/script'); ?>
<?= $this->endSection(); ?>
