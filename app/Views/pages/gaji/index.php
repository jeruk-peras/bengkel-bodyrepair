<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Gaji Karyawan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Gaji Karyawan</h6>
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
                            <th>Tanggal</th>
                            <th>Priode</th>
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
                            <label for="tanggal" class="form-label required">Tanggal</label>
                            <input type="datetime-local" name="tanggal" class="form-control" id="tanggal" placeholder="Tanggal" value="<?= date('Y-m-d H:i'); ?>">
                            <div class="invalid-feedback" id="invalid_tanggal"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="periode" class="form-label required">Periode</label>
                            <select name="periode" class="form-select" id="periode">
                                <?php $tahun = date("Y");
                                $start = new DateTime("$tahun-01-01");
                                $end = new DateTime("$tahun-12-01"); ?>
                                <?php while ($start <= $end) :
                                    $periode = $start->format("F - Y");
                                    $start->modify("+1 month"); ?>
                                    <option value="<?= $periode; ?>"><?= $periode; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <div class="invalid-feedback" id="invalid_periode"></div>
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
<?= $this->include('pages/gaji/script'); ?>
<?= $this->endSection(); ?>