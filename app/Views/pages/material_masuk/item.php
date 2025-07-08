<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Material Masuk</li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Material Masuk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Form Material Masuk</h6>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-1">
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal Masuk</label>
                    <input type="datetime-local" class="form-control" readonly disabled value="<?= $data['tanggal']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="no_delivery" class="form-label">Nomor Delivery</label>
                    <input type="text" class="form-control" readonly disabled value="<?= $data['no_delivery']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="suplier" class="form-label">Suplier</label>
                    <input type="text" class="form-control" readonly disabled value="<?= $data['suplier']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="tel" class="form-control" readonly disabled value="<?= $data['total_harga']; ?>">
                </div>
                <div class="col-md-12">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" readonly disabled><?= $data['catatan']; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4 col-sm-4 col-md-6 col-lg-6">
            <a href="<?= base_url('material-masuk'); ?>" class="btn btn-sm btn-secondary"><i class="bx bx-arrow-back"></i> Kembali</a>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#data-material-modal"><i class="bx bx-plus"></i> Tambah</button>
        </div>
        <div class="col-8 col-sm-8 col-md-6 col-lg-6 text-end">
            <a href="/material-masuk/<?= $data['id_material_masuk'] ?>/delete" class="btn btn-sm btn-warning" id="cancel-all">Batalkan Semua</a>
            <button class="btn btn-sm btn-primary" id="btn-sync">Singkronkan Data</button>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Item Material Masuk</h6>
                </div>
                <div class="ms-auto"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="" method="post" id="form-item">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_material_masuk" value="<?= $data['id_material_masuk'] ?>">
                    <table class="table align-middle mb-0" id="" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Nama Material</th>
                                <th>Stok Sisa</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="data-item"></tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="data-material-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Cabang</th>
                                <th>Jenis</th>
                                <th>Nama Material</th>
                                <th>Satuan</th>
                                <th>Merek</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var table = $('#datatable');
    // katika modal di buka
    $('#data-material-modal').on('show.bs.modal', function() {
        table.DataTable({
            processing: true,
            serverSide: true,
            ordering: false, // Set true agar bisa di sorting
            // colReorder: {
            //     order: [0, 2, 3, 4, 8, 5, 6, 7, 1]
            // },
            columns: [{
                    data: 0
                },
                {
                    data: 2
                },
                {
                    data: 3
                },
                {
                    data: 4
                },
                {
                    data: 8
                },
                {
                    data: 5
                },
                {
                    data: 6
                },
                {
                    data: 7
                },
                {
                    data: 1
                },
            ],
            ajax: {
                url: '/datatable-server-side/material', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 8, // Target kolom
                render: function(data, type, row, meta) {
                    var btn =
                        '<button data-idMaterial="' + data + '" class="me-2 btn btn-sm btn-primary btn-addItem"><i class="bx bx-plus me-0"></i></button>'
                    return btn;
                }
            }, ],
            pageLength: 25,
            lengthMenu: [25, 50, 100, 'All'],
            scrollX: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
            },
        });
    });

    // ketika modal di tutup
    $('#data-material-modal').on('hidden.bs.modal', function() {
        table.DataTable().clear().destroy();
    });

    // ketika tambah item di klik
    table.on('click', 'tbody tr td button.btn-addItem', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-idMaterial');

        $.ajax({
            url: '/material-masuk/<?= $data['id_material_masuk'] ?>/add-item',
            type: 'POST',
            data: {
                <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                id_material: id
            },
            success: function(response) {
                // $('#data-material-modal').modal('hide');
                renderItem();
                alertMesage(response.status, response.message);

            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    });

    // ketika item di hapus
    $(document).on('click', 'tbody#data-item tr td button.btn-delete-item', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/material-masuk/del-item',
            type: 'POST',
            data: {
                <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                id: id
            },
            success: function(response) {
                renderItem();
                alertMesage(response.status, response.message);

            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    })

    // ketika harga / stok di ubah
    $(document).on('keyup', '.input-change', function() {
        var formData = $('#form-item').serialize()
        $.ajax({
            url: '/material-masuk/item-temp-save',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    })

    // handle btn sync
    $('#btn-sync').click(function() {
        var formData = $('#form-item').serialize()
        $.ajax({
            url: '/material-masuk/sync-data-item',
            type: 'POST',
            data: formData,
            success: function(response) {
                alertMesage(response.status, response.message);
                window.location.href = response.data.redirect;
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    });

    // batalkam semua/hapus semua
    // hendle delete button
    $('#cancel-all').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus semua data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        alertMesage(response.status, response.message);
                        window.location.href = response.data.redirect;
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        alertMesage(response.status, response.message);
                    }
                });
            }
        });
    })

    // render item
    function renderItem() {
        $.ajax({
            url: '/material-masuk/render-item',
            type: 'POST',
            data: {
                <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                id_material_masuk: '<?= $data['id_material_masuk'] ?>'
            },
            success: function(response) {
                $('#data-item').html(response.data);
            },
            error: function(xhr, status, error) {
                $('#data-item').html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data item.</td></tr>');
            }
        });
    }
    renderItem();
</script>
<?= $this->endSection(); ?>