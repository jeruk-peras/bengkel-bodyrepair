<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Closing</li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Closing</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="<?= base_url('closing'); ?>" class="btn btn-sm btn-primary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
            <?php if (session()->get('role') == 'Super Admin' && $data['status'] == 0): ?>
                <a href="<?= base_url('closing'); ?>" class="btn btn-sm btn-primary btn-lock"><i class="bx bx-lock-open"></i> Lock Data</a>
            <?php elseif (session()->get('role') == 'Super Admin' && $data['status'] == 1): ?>
                <a href="<?= base_url('closing'); ?>" class="btn btn-sm btn-primary btn-lock"><i class="bx bx-lock"></i> Locked</a>
            <?php endif;  ?>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Closing</label>
                    <input type="datetime-local" class="form-control" disabled value="<?= $data['tanggal'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Periode Closing</label>
                    <input type="text" class="form-control" disabled value="<?= $data['periode_closing'] ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control" disabled><?= $data['catatan'] ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-sm-6 col-lg-6 col-xl-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Panel</p>
                            <h4 class="my-1" id="total_panel">0</h4>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 col-sm-6 col-lg-6 col-xl-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Pemakaian Bahan</p>
                            <h4 class="my-1" id="pemakaian_bahan">0</h4>
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class="bx bxs-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7 col-sm-6 col-lg-6 col-xl-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Pendapatkan</p>
                            <h4 class="my-1" id="total_pendapatan">0</h4>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="bx bx-line-chart-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills mb-3 justify-content-between" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="pill" href="#data-unit" role="tab" aria-selected="true">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-detail font-18 me-1"></i>
                    </div>
                    <div class="tab-title">Data Unit</div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="pill" href="#pemakaian-bahan" id="tab-pemakaian-bahan" role="tab" aria-selected="false" tabindex="-1">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-book font-18 me-1"></i>
                    </div>
                    <div class="tab-title">Pemakaian Bahan</div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="pill" href="#closing-mekanik" id="tab-closing-mekanik" role="tab" aria-selected="false" tabindex="-1">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-briefcase font-18 me-1"></i>
                    </div>
                    <div class="tab-title">Closing Mekanik</div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="pill" href="#closingan" id="tab-closingan" role="tab" aria-selected="false" tabindex="-1">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-bar-chart-alt font-18 me-1"></i>
                    </div>
                    <div class="tab-title">Closingan</div>
                </div>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade active show" id="data-unit" role="tabpanel">
            <div class="card radius-10">
                <?php if ($data['status'] == 0):  ?>
                    <div class="card-header border-0 bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="col-8">
                                <form class="d-flex align-items-center" method="POST" action="/closing/add-unit" id="add-unit-form">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="closing_id" id="closing_id" value="<?= $data['id_closing']; ?>">
                                    <select name="unit_id" id="select-unit" class="form-select form-select-sm me-2" style="min-width: 100px;"></select>
                                    <button type="submit" class="btn btn-sm btn-primary text-nowrap"><i class="bx bx-plus"></i> Tambah Data Unit</button>
                                </form>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-kolektif"><i class="bx bx-bracket"></i> Tambah Kolektif Data Unit</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>#</th>
                                    <th>Nama Cabang</th>
                                    <th>Nomor SPP</th>
                                    <th>Nomor Polisi</th>
                                    <th>Model/Warna</th>
                                    <th>Taggal Masuk</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Penel</th>
                                    <th>Harga SPP</th>
                                    <th>Diskon</th>
                                    <th>Total Harga SPP</th>
                                    <th>Nama SA</th>
                                    <th>Asuransi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pemakaian-bahan" role="tabpanel">
            <div class="card radius-10">
                <div class="card-header border-0 bg-transparent">
                    <div class="d-flex align-items-center">
                        <div class="col-8">
                            <h6 class="mb-0">Laporan Pemakaian Bahan</h6>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-sm btn-primary btn-print" data-print="bahan"><i class="bx bx-printer"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="print-data" class="m-3">
                        <style>
                            .table-header {
                                border-collapse: collapse;
                                width: 100%;
                                margin-bottom: 20px;
                            }

                            .table-header td {
                                border: 1px solid #000;
                                padding: 3px;
                                color: #000;
                            }

                            .table-header th {
                                border: 1px solid #000;
                                padding: 1px;
                                color: #000 !important;
                                text-align: center;
                                font-weight: bold !important;
                            }

                            .photo-grid {
                                width: 100%;
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                grid-gap: 10px;
                            }

                            .photo-grid div {
                                border: 2px solid #000;
                                height: 350px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                overflow: hidden;
                            }

                            @media print {
                                @page {
                                    size: A4;
                                    orientation: lanscape;
                                    margin: 2cm;
                                    /* Atau margin yang berbeda untuk setiap sisi */
                                }

                            }

                            h2 {
                                text-align: center;
                                margin-bottom: 10px;
                            }

                            .kop-surat {
                                text-align: center;
                                /* border-bottom: 2px solid #000; */
                                padding-bottom: 10px;
                                /* margin-bottom: 20px; */
                            }

                            .kop-surat h2 {
                                margin-top: 0;
                                margin-bottom: 0;
                            }

                            .kop-surat img {
                                max-height: 70px;
                                /* margin-bottom: 10px; */
                            }
                        </style>

                        <div class="kop-surat">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Perusahaan" style="max-height:90px; margin-right:20px;">
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <div>
                                        <h2 class="text-black text-end" style="margin:0; font-size: 48px; font-weight: 700; text-align: left;">PT. NUR LISAN SAKTI</h2>
                                        <p style="width: 500px; margin: 0; text-align: end;">Jalan Daan Mogot Km. 10, Komp. Departemen Agama No.36-37, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11710</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="fw-bold text-black">PEMAKAIAN BAHAN</h2>

                        <table class="table-header" id="data-pemakaian-material"></table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="closing-mekanik" role="tabpanel">
            <div class="card radius-10">
                <div class="card-header border-0 bg-transparent">
                    <div class="d-flex align-items-center">
                        <div class="me-5">
                            <h6 class="mb-0">Laporan Closing Mekanik</h6>
                        </div>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-sm btn-primary btn-print" data-print="mekanik"><i class="bx bx-printer"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="data-closingan-mekanik">
                        <div class="text-center p-5">
                            <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="closingan" role="tabpanel">
            <div class="card radius-10">
                <div class="card-header border-0 bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0 me-5">Laporan Closingan</h6>
                        </div>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-sm btn-primary btn-print" data-print="closing"><i class="bx bx-printer"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="data-closingan"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="modal-tambah-kolektif" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kolektif Data Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/closing/savekolektifunit" method="POST" id="form-select">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="closing_id" id="closing_id" value="<?= $data['id_closing']; ?>">
                </form>
                <table class="table align-middle mb-0 text-nowrap table-hover" id="datatableTambahUnit" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Nama Cabang</th>
                            <th>Nomor SPP</th>
                            <th>Nomor Polisi</th>
                            <th>Model/Warna</th>
                            <th>Taggal Masuk</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Penel</th>
                            <th>Harga SPP</th>
                            <th>Diskon</th>
                            <th>Total Harga SPP</th>
                            <th>Nama SA</th>
                            <th>Asuransi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-simpan-kolektif">Simpan Konlektif</button>
            </div>
        </div>
    </div>
</div>

<?php if (session()->get('role') == 'Super Admin'):  ?>
    <div class="modal fade" id="lock-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lock Data Closing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/closing/<?= $data['id_closing']; ?>/lock" method="post" id="form-lock-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="password">
                                <div class="invalid-feedback" id="invalid_password"></div>
                                <div class="form-text">* Untuk lock dan unlock data closing masukan password akun Super Admin</div>
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
<?php endif; ?>

<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script src="<?= base_url('/assets/js/jquery.PrintArea.js'); ?>"></script>
<?= $this->include('layout/tomselect'); ?>
<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/' + $('#closing_id').val() + '/closing', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
                targets: 0, // Target kolom
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('mark-unit ' + rowData[15]).attr('data-id', rowData[1]);
                }
            }, <?php if ($data['status'] == 0): ?> {
                    targets: 1, // Target kolom
                    render: function(data, type, row, meta) {
                        var btn =
                            '<a href="/closing/' + data + '/del-unit" class="me-2 btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Data"><i class="bx bx-trash me-0"></i></a>'
                        return btn;
                    }

                }, <?php endif; ?> {
                    targets: 8, // Target kolom
                    render: function(data, type, row, meta) {
                        var btn = row[16] == 1 ? '<span class="badge bg-success px-3 w-100">' + data + '</span>' : '<span class="badge bg-primary w-100">' + data + ' </span>'
                        return btn;
                    }
            }, <?= $data['status'] == 0 ? "" : "{ targets: 1, visible: false }," ?>
            <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>
        ],
        pageLength: 50,
        lengthMenu: [50, 100, 200],
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

    <?php if (session()->get('role') == 'Super Admin'): ?>
        // hendle lock data
        $('a.btn-lock').click(function(e) {
            e.preventDefault();
            $('#lock-modal').modal('show');
        })

        $('#form-lock-data').submit(function(e) {
            e.preventDefault();
            var url, formData;
            url = $(this).attr('action');
            formData = $(this).serializeArray();
            $('#btn-simpan').attr('disabled', true).text('Menyimpan...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#lock-modal').modal('hide');
                    table.ajax.reload(null, false); // Reload data tanpa reset pagination
                    alertMesage(response.status, response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 300)
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    $('#form-lock-data .form-control').removeClass('is-invalid');
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
    <?php endif; ?>

    // hendle delete button
    table.on('click', 'tbody tr td a.btn-delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data ini?",
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
                        dataUnit();
                        fetchSummaryDataClosing();
                        table.ajax.reload(null, false); // Reload data tanpa reset pagination
                        alertMesage(response.status, response.message);
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        alertMesage(response.status, response.message);
                    }
                });
            }
        });
    })

    // hendle untuk select unit yang akan ditambahkan
    let tomSelectSPP;
    dataUnit();

    function dataUnit() {
        if (tomSelectSPP) tomSelectSPP.destroy();

        $.ajax({
            url: '/api/' + $('#closing_id').val() + '/fetchunit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#select-unit');
                $select.empty().append('<option value="">-- Pilih Nomor SPP --</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_unit + '">' + item.nomor_spp + ' | ' + item.nomor_polisi + ' | ' + item.model_unit + '</option>');
                });

                tomSelectSPP = new TomSelect("#select-unit", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // hendle add unit
    $('#add-unit-form').submit(function(e) {
        e.preventDefault();

        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                dataUnit();
                fetchDataPemakaianMaterial();
                fetchSummaryDataClosing();
                fetchDataClosingMekanik();
                fetchDataClosing();
                table.ajax.reload(null, false); // Reload data tanpa reset pagination
                alertMesage(response.status, response.message);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle Tambah Kolektif Data Unit
    let datatableTambahUnit
    $('#modal-tambah-kolektif').on('show.bs.modal', function() {
        setTimeout(function() {
            addKolektifDataUnit();
        }, 200);
    })
    $('#modal-tambah-kolektif').on('hidden.bs.modal', function() {
        datatableTambahUnit.clear().destroy();
    })

    function addKolektifDataUnit() {
        datatableTambahUnit = $('#datatableTambahUnit').DataTable({
            processing: true,
            serverSide: true,
            ordering: false, // Set true agar bisa di sorting
            ajax: {
                url: '/datatable-server-side/' + $('#closing_id').val() + '/fetchunitkolektif', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 0, // Target kolom
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('mark-unit ' + rowData[15]).attr('data-id', rowData[1]);
                }
            }, {
                targets: 1, // Target kolom
                checkboxes: {
                    selectRow: true
                },

            }, {
                targets: 8, // Target kolom
                render: function(data, type, row, meta) {
                    var btn = row[16] == 1 ? '<span class="badge bg-success px-3 w-100">' + data + '</span>' : '<span class="badge bg-primary w-100">' + data + ' </span>'
                    return btn;
                }
            }, <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>],
            pageLength: 50,
            lengthMenu: [50, 100, 200],
            scrollX: true,
            select: {
                style: 'multi'
            },
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
            },
        });
    }

    $('#btn-simpan-kolektif').click(function() {
        var formData = $('#form-select');
        var rows_selected = datatableTambahUnit.column(1).checkboxes.selected();

        $.each(rows_selected, function(index, rowId) {
            formData.append(
                $('<input>').attr('type', 'hidden').attr('name', 'unit_id[]').val(rowId)
            );
        });

        var url = formData.attr('action');
        formData = formData.serializeArray();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                dataUnit();
                fetchDataPemakaianMaterial();
                fetchSummaryDataClosing();
                fetchDataClosingMekanik();
                fetchDataClosing();
                table.ajax.reload(null, false);
                alertMesage(response.status, response.message);
                $('#modal-tambah-kolektif').modal('hide');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle click tab
    $('#tab-pemakaian-bahan').click(() => fetchDataPemakaianMaterial())
    $('#tab-closing-mekanik').click(() => fetchDataClosingMekanik())
    $('#tab-closingan').click(() => fetchDataClosing())

    // hendle data pemekaian bahan
    function fetchDataPemakaianMaterial() {
        const id = $('#closing_id').val();
        $.ajax({
            url: '/closing/' + id + '/pemakaian-bahan-detail',
            method: 'GET',
            success: function(response) {
                $('#data-pemakaian-material').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // summary data
    fetchSummaryDataClosing();

    function fetchSummaryDataClosing() {
        const id = $('#closing_id').val();
        $.ajax({
            url: '/closing/' + id + '/summary-closing',
            method: 'GET',
            success: function(response) {

                $.each(response.data, function(index, value) {
                    $('#' + index).text(value);
                })

            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // closing mekanik data
    function fetchDataClosingMekanik() {
        const id = $('#closing_id').val();
        $.ajax({
            url: '/closing/' + id + '/closing-mekanik',
            method: 'GET',
            success: function(response) {
                $('#data-closingan-mekanik').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // closing data
    function fetchDataClosing() {
        const id = $('#closing_id').val();
        $.ajax({
            url: '/closing/' + id + '/closingan',
            method: 'GET',
            success: function(response) {
                $('#data-closingan').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    $('.btn-print').click(function() {
        var dataPrint = $(this).attr('data-print');

        if (dataPrint == 'bahan') {

            // Jalankan PrintArea
            $('#print-data').printArea();

        } else if (dataPrint == 'mekanik') {

            // Jalankan PrintArea
            $('#data-closingan-mekanik').printArea();

        } else if (dataPrint == 'closing') {

            // Jalankan PrintArea
            $('#data-closingan').printArea();
        }

    });
</script>

<?= $this->endSection(); ?>