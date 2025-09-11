<?php foreach ($item as $row):  ?>
    <div class="col">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/images/inventory/<?= $row['gambar']; ?>" alt="<?= $row['nama_barang']; ?>" class="card-img">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nama_barang']; ?></h5>
                        <p><?= $row['deskripsi']; ?></p>
                        <hr>
                        <div class="d-flex align-items-center justify-content-center gap-1">
                            <a href="/inventory/<?= $row['id_inventory']; ?>/edit" class="me-2 btn btn-sm btn-primary btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Data"><i class="bx bx-pencil me-0"></i></a>
                            <a href="/inventory/<?= $row['id_inventory']; ?>/delete" class="me-2 btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Data"><i class="bx bx-trash me-0"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>