<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"> Users </li>
                    <li class="breadcrumb-item active" aria-current="page">Users Akses</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Add Users Akses Cabang</h6>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <?= csrf_field(); ?>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" value="<?= $user['nama_lengkap']; ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control form-control-sm" value="<?= $user['username']; ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control form-control-sm" value="<?= $user['role']; ?>" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Pilih Akses Cabang :</label>
                    <div class="col-sm-9">
                        <?php foreach ($cabang as $row):  ?>
                            <div class="form-check">
                                <input class="form-check-input" id="<?= $row['nama_cabang']; ?>" <?= userAkasesCabang($user['id_user'], $row['id_cabang']) ? 'checked' : ''; ?> type="checkbox" name="cabang[<?= $row['id_cabang']; ?>]">
                                <label class="form-check-label" for="<?= $row['nama_cabang']; ?>"><?= $row['nama_cabang']; ?></label>
                            </div>
                        <?php endforeach;  ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>