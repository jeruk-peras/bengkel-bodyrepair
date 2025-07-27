    <?= $this->extend('layout/index'); ?>
    <?= $this->section('content'); ?>
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
            <div class="ps-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Users</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto"></div>
        </div>

        <div class="card radius-10">
            <div class="card-header border-0 bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Daftar Users</h6>
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
                                <th>Nama Lengkap</th>
                                <th>no_handphone</th>
                                <th>Alamat</th>
                                <th>Username</th>
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
                        <div class="row g-3 mb-3" id="field-data">
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap">
                                <div class="invalid-feedback" id="invalid_nama_lengkap"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="no_handphone" class="form-label required">No Handphone</label>
                                <input type="text" name="no_handphone" class="form-control" id="no_handphone" placeholder="No Handphone">
                                <div class="invalid-feedback" id="invalid_no_handphone"></div>
                            </div>
                            <div class="col-md-12">
                                <label for="alamat" class="form-label required">Alamat</label>
                                <textarea type="text" name="alamat" class="form-control" id="alamat"></textarea>
                                <div class="invalid-feedback" id="invalid_alamat"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                <div class="invalid-feedback" id="invalid_username"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label required">Role</label>
                                <select name="role" class="form-control" id="role">
                                    <option value="Admin Cabang">Admin Cabang</option>
                                    <?php if (session('user_type') == 'admin' && session('role') == 'Super Admin'):  ?>
                                        <option value="Admin">Admin</option>
                                        <option value="Super Admin">Super Admin</option>
                                    <?php endif;  ?>
                                </select>
                                <div class="invalid-feedback" id="invalid_role"></div>
                            </div>
                        </div>
                        <div class="row g-3" id="field-password">
                            <div class="col-md-6">
                                <label for="password" class="form-label required">Password</label>
                                <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                                <div class="invalid-feedback" id="invalid_password"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label required">Confirm Password</label>
                                <input type="text" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                                <div class="invalid-feedback" id="invalid_confirm_password"></div>
                            </div>
                            <div class="form-text">*Minimal 8 Karakter kombinasi huruf kapital, huruf kecil, angka dan simbol.</div>
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
    <?= $this->include('pages/users/script'); ?>
    <?= $this->endSection(); ?>