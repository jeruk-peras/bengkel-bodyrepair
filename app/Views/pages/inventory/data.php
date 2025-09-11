<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Asset Bengkel</li>
                    <li class="breadcrumb-item active" aria-current="page">Data Asset Bengkel</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Asset Bengkel</h6>
                </div>
                <div class="ms-auto">
                    <!-- <a href="<?= base_url('closing/add'); ?>" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah</a> -->
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
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Rusak</th>
                            <th>Kondisi</th>
                            <th>Catatan</th>
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
            <form action="" method="post" id="form-data" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="" id="image" alt="..." class="card-img">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title" id="nama_barang"></h5>
                                            <p id="deskripsi"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label required">Jumlah Barang</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah">
                            <div class="invalid-feedback" id="invalid_jumlah"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="rusak" class="form-label required">Rusak</label>
                            <input type="number" name="rusak" class="form-control" id="rusak" placeholder="Rusak">
                            <div class="invalid-feedback" id="invalid_rusak"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="gambar_kond" class="form-label">Gambar Kondisi</label>
                            <input type="file" name="gambar" class="form-control mb-1" id="gambar_kond">
                            <img src="" id="preview" alt="" width="40%">
                            <div class="invalid-feedback" id="invalid_gambar"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" id="catatan"></textarea>
                            <div class="invalid-feedback" id="invalid_harga"></div>
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

<div class="modal fade" id="modal-gambar-kondisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary fw-bolder" id="nama-barang"></h1>
                <button type="button" id="close-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" id="gambar-kondisi" class="img-fluid" alt="Gambar" style="max-height: 500px; max-width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/inventory_cabang', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
                targets: 1, // Target kolom
                render: function(data, type, row, meta) {
                    var btn =
                        '<a href="/inventory/assets/' + data + '/edit" class="me-2 btn btn-sm btn-primary btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Data"><i class="bx bx-pencil me-0"></i></a>'
                    return btn;
                }
            }, {
                targets: 6, // Target kolom
                render: function(data, type, row, meta) {
                    var btn =
                        '<a href="/inventory/assets/' + row[1] + '/image" class="me-2 btn btn-sm btn-primary btn-gambar-kondisi" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Gambar Kondisi"><i class="bx bx-info-circle me-0"></i></a>'
                    return btn;
                }
            },
            <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>
        ],
        pageLength: 25,
        lengthMenu: [25, 50, 100, 'All'],
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
        },
    });

    table.on('draw.dt', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // hendle save data
    $('#form-data').submit(function(e) {
        e.preventDefault();
        var url, formData;
        url = $(this).attr('action');
        formData = new FormData(this); // penting: gunakan FormData
        $('#btn-simpan').attr('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, // penting
            contentType: false, // penting
            success: function(response) {
                $('#form-data-modal').modal('hide');
                table.ajax.reload(null, false); // Reload data tanpa reset pagination
                alertMesage(response.status, response.message);
                $('#btn-simpan').attr('disabled', false).text('Simpan data');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#btn-simpan').attr('disabled', false).text('Simpan data');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle edit button
    table.on('click', 'tbody tr td a.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#form-data').attr('action', url);
                $('#form-data-modal').modal('show');
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value);
                });
                $('#nama_barang').text(response.data.nama_barang);
                $('#deskripsi').text(response.data.deskripsi);
                $('#image').attr('src', response.data.gambar);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data').attr('action', '');
                alertMesage(response.status, response.message);
            }
        });
    })

    // gambar kondisi
    table.on('click', 'tbody tr td a.btn-gambar-kondisi', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#modal-gambar-kondisi').modal('show');
                $('#nama-barang').text(response.data.nama_barang);
                $('#gambar-kondisi').attr('src', response.data.gambar_kondisi);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data').attr('action', '');
                alertMesage(response.status, response.message);
            }
        });
    })

    $('#gambar_kond').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#preview').attr('src', '').hide();
        }
    });
</script>
<?= $this->endSection(); ?>