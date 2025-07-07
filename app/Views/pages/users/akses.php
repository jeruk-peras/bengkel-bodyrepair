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
                    <h6 class="mb-0">Users Akses Cabang</h6>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Nama User</th>
                            <th>Akses Cabang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($users as $u): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <a href="/users/akses-add/<?= $u['id_user']; ?>" class="btn btn-sm btn-primary"><i class="bx bx-pencil me-0"></i></a>
                                </td>
                                <td><?= $u['nama_lengkap']; ?><br /><small><?= $u['username']; ?> - <?= $u['role']; ?></small></td>
                                <td><?= userAkases($u['id_user']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php if (session('message')): ?>
    <script>
        alertMesage(200, <?= session('message') ?>);
    </script>
<?php endif;  ?>
<?= $this->endSection(); ?>