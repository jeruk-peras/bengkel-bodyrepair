<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Inventory</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Inventory</h6>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2" id="load-data"></div>
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
                            <label for="nama_barang" class="form-label required">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="Nama Barang">
                            <div class="invalid-feedback" id="invalid_nama_barang"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="imageInput" class="form-label required">Gambar Barang</label>
                            <input type="file" name="gambar" class="form-control" id="imageInput">
                            <div class="invalid-feedback" id="invalid_gambar"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="deskripsi" class="form-label required">Deskripsi</label>
                            <textarea type="text" name="deskripsi" class="form-control" cols="3" id="deskripsi"></textarea>
                            <div class="invalid-feedback" id="invalid_deskripsi"></div>
                        </div>
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-9">
                                <img id="image" style="max-width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->include('pages/inventory/script');?>
<?= $this->endSection(); ?>