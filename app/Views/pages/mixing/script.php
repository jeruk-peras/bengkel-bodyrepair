<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/unit', // URL file untuk proses select datanya
            type: 'POST',
            data: function(d) {
                d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                d.filter = $('#datatable').attr('data-filter');
            } // Kirim token CSRF
        },
        columnDefs: [{
                targets: 0, // Target kolom
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('mark-unit ' + rowData[12]).attr('data-id', rowData[1]);
                }
            },
            {
                targets: 1, // Target kolom
                render: function(data, type, row, meta) {
                    var btn =
                        '<button data-id="' + data + '" class="me-2 btn btn-sm btn-primary btn-add-material" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Material"><i class="bx bx-plus me-0"></i></button>' +
                        '<a href="/material-mixing/' + data + '/detail" class="me-2 btn btn-sm btn-primary btn-detail" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Data"><i class="bx bx-info-circle me-0"></i></a>'
                    return btn;
                }
            }, {
                targets: 8, // Target kolom
                render: function(data, type, row, meta) {
                    var btn = row[13] == 1 ? '<span class="badge bg-success btn-selesai px-3 w-100" data-id="">'+ data +'</span>' :  '<span class="badge bg-primary w-100">' + data + ' </span>'
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
       refreshTooltips();
    });

    // hendle btn-add-material button
    table.on('click', 'tbody tr td button.btn-add-material', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#form-add-material').attr('action', '/material-mixing/' + id + '/add');
        $('#modal-material-data').modal('show');
    })

    // hendle detail button
    table.on('click', 'tbody tr td a.btn-detail', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var id = $(this).attr('data-id');

    })

    // penggunaan material
    $('#modal-material-data').on('show.bs.modal', function() {
        dataMaterial('#material_id');
        dataMekanik('#mekanik_id');
    });

    // add row
    $('#btn-add-row').click(function() {
        var material = $('#material_id').html();
        var $html =
            `<div class="row mt-2 row-material" id="row-material">
                <div class="col-sm-12 col-md-12 col-lg-5 col-12" style="padding-right: 5px !important;">
                    <select class="form-select form-select-sm select-material tom-select" name="material_id[]" required>${material}</select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2 col-6" style="padding: 0 5px 0 5px !important;"> 
                    <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        <input type="text" name="harga[]" class="form-control form-control-sm harga-material" readonly required placeholder="xxxxxx"  style="padding-left: 2.5rem; padding-right: 1.90rem;">
                        <span class="position-absolute top-50 translate-middle-y satuan-material" style="right: 15px !important; left: unset;"></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2 col-6" style="padding: 0 5px 0 5px !important;">
                   <div class="position-relative input-icon">
                        <input type="text" inputmode="numeric" name="jumlah[]" class="form-control form-control-sm" id="jumlah" required style="padding-left: 0.5rem; padding-right: 3rem;">
                        <span class="position-absolute top-50 translate-middle-y stok-material" style="right: 10px !important; left: unset;"></span>
                    </div>
                </div>
                <div class="col-sm-10 col-md-4 col-lg-2 col-10" style="padding: 0 5px 0 5px !important;">
                     <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y">Rp</span>
                        <input type="text" class="form-control form-control-sm" id="display_total_harga" required readonly style="padding-left: 2.5rem;">
                        <input type="hidden" name="total_harga[]" id="total_harga">
                    </div>
                </div>
                <div class="col align-self-end" style="padding-left: 5px !important;">
                    <button type="button" class="btn btn-danger w-100 btn-sm" id="btn-del-row">-</button>
                </div>
            </div>`;
        $('#row-material').after($html);

        new TomSelect(".tom-select", {
            placeholder: 'Pilih opsi...',
            sortField: {
                field: "text",
                direction: "asc"
            },
            onInitialize: function() {
                // Fokus ke input Tom Select setelah inisialisasi
                setTimeout(() => {
                    this.control_input.focus();
                }, 10);
            }
        });
    })

    // handle delete row
    $(document).on('click', '#btn-del-row', function() {
        $(this).closest('#row-material').remove();
    });

    // untuk mengisi filed harga, jumlah
    $(document).on('change', '.select-material', function() {
        var harga = $(this).find('option:selected').attr('data-harga');
        $(this).closest('#row-material').find('.harga-material').val(formatRupiah(harga));

        var satuan = $(this).find('option:selected').attr('data-satuan');
        $(this).closest('#row-material').find('.satuan-material').text(satuan);

        var stok = $(this).find('option:selected').attr('data-stok');
        $(this).closest('#row-material').find('.stok-material').text('/' + stok);

        $(this).closest('#row-material').find('#jumlah').val('');
        $(this).closest('#row-material').find('#display_total_harga').val('');
        $(this).closest('#row-material').find('#total_harga').val('');
    })

    // buat validasi sisa stok dengan jumlah
    $(document).on('keyup change', '.select-material, .harga-material, #jumlah', '.satuan-material', function() {
        var $row = $(this).closest('#row-material');
        var stokText = $row.find('.stok-material').text().replace('/', '');
        var stok = parseFloat(stokText) || 0;
        var jumlah = parseFloat($row.find('#jumlah').val()) || 0;

        if (jumlah > stok) {
            $row.find('#jumlah').val(stok); // Reset jumlah ke stok maksimum
        }
    });

    $(document).on('keyup change', '#jumlah', function() {
        var $row = $(this).closest('#row-material');
        var harga = $row.find('.harga-material').val() || 0;
        var jumlah = parseFloat($row.find('#jumlah').val()) || 0;
        harga = resetRupiah(harga)

        total_harga = harga * jumlah;
        console.log(jumlah, harga, total_harga)

        $row.find('#display_total_harga').val(total_harga.toLocaleString('id-ID', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }));
        $row.find('#total_harga').val(total_harga);
    });

    // instance tom select
    let tomSelectMaterial = null;
    let tomSelectMekanik = null;

    function dataMaterial(target, val = null) {

        if (tomSelectMaterial !== null) tomSelectMaterial.destroy();

        $.ajax({
            url: '/api/material',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $(target);
                $select.empty().append('<option value="">Pilih opsi...</option>');
                $.each(response.data, function(index, item) {
                    var selected = (val !== null && val == item.id_material) ? ' selected' : '';
                    $select.append('<option data-stok="' + item.stok + '" data-satuan="' + item.nama_satuan + '" data-harga="' + item.harga + '" value="' + item.id_material + '"' + selected + '>' + item.nama_material + '</option>');
                });

                tomSelectMaterial = new TomSelect(target, {
                    placeholder: 'Pilih opsi...',
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
                setTimeout(function() {
                    $('#modal-material-data').modal('hide');
                }, 500)
            }

        });
    }

    function dataMekanik(target, val = null) {
        if (tomSelectMekanik !== null) tomSelectMekanik.destroy();

        $.ajax({
            url: '/api/mekanik',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $(target);
                $select.empty().append('<option value="" hidden>-- Pilih Mekanik --</option>');
                $.each(response.data, function(index, item) {
                    var selected = (val !== null && val == item.id_mekanik) ? ' selected' : '';
                    $select.append('<option value="' + item.id_mekanik + '"' + selected + '>' + item.nama_mekanik + '</option>');
                });

                tomSelectMekanik = new TomSelect(target, {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    onInitialize: function() {
                        // Fokus ke input Tom Select setelah inisialisasi
                        if (val == null) {
                            setTimeout(() => {
                                this.control_input.focus();
                            }, 10);
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
                setTimeout(function() {
                    $('#modal-material-data').modal('hide');
                }, 500)
            }

        });
    }

    // hendle add material
    $('#btn-material').click(function() {
        var url, formData;
        url = $('#form-add-material').attr('action');
        formData = $('#form-add-material').serializeArray();
        $('#btn-material').attr('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#btn-material').attr('disabled', false).text('Simpan data');
                $('#modal-material-data').modal('hide');
                $('#form-add-material').removeClass('is-invalid');

                $('#form-add-material')[0].reset();
                $('.row-material').not(':first').remove(); // Hapus semua baris kecuali yang pertama
                $('.row-material').eq(0).find('input, select').val(''); // Kosongkan input dari baris pertama
                $('.row-material .stok-material').text('');
                $('.row-material .satuan-material').text('');
                alertMesage(response.status, response.message);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-add-material .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                $('#btn-material').attr('disabled', false).text('Simpan data');
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle btn-add-material button
    table.on('click', 'tbody tr td a.btn-detail', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#material-unit').html(response.data.html)
            }
        });
        $('#modal-material').modal('show');
    })

    // handele del btn
    $(document).on('click', '#data-material-unit tbody tr td a.btn-del', function(e) {
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
    
    // hendle modal edit material
    $(document).on('dblclick', '#material-table tbody tr.row-material', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '/material-keluar/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                $('#form-edit-material').attr('action', '/material-keluar/' + id + '/edit')

                $('#edit-tanggal').val(response.data.tanggal);
                $('.edit').find('.harga-material').val(formatRupiah(response.data.harga));
                $('.edit').find('.satuan-material').text(response.data.nama_satuan);
                $('.edit').find('.stok-material').text('/' + response.data.stok);
                $('.edit').find('#jumlah').val(response.data.jumlah);
                $('.edit').find('#display_total_harga').val(formatRupiah(response.data.total_harga));
                $('.edit').find('#total_harga').val(response.data.total_harga);

                dataMaterial('#material_data', response.data.id_material);
                dataMekanik('#mekanik_data', response.data.id_mekanik);
                $('#modal-edit-material').modal('show');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle add material
    $('#btn-update-material').click(function() {
        var url, formData;
        url = $('#form-edit-material').attr('action');
        formData = $('#form-edit-material').serializeArray();
        $('#btn-update-material').attr('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#btn-update-material').attr('disabled', false).text('Simpan data');
                $('#modal-edit-material').modal('hide');
                $('#form-edit-material').removeClass('is-invalid');

                $('#form-edit-material')[0].reset();
                $('.row-material').eq(0).find('input, select').val(''); // Kosongkan input dari baris pertama
                $('.row-material .stok-material').text('');
                $('.row-material .satuan-material').text('');
                alertMesage(response.status, response.message);

                var filter = $('#datatable').attr('data-filter');
                fetchDataMaterial(filter);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-edit-material .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                $('#btn-update-material').attr('disabled', false).text('Simpan data');
                alertMesage(response.status, response.message);
            }
        })

    })

    $('.btn-filter').click(function() {
        var f = $(this).attr('data-f');
        $('#datatable').attr('data-filter', f);
        table.ajax.reload();

        $('.btn-filter').removeClass('active');
        $(this).addClass('active');
        fetchDataMaterial(f);
    })

    // handle data material
    $('#tab-material').click(function() {
        var filter = $('#datatable').attr('data-filter');
        console.log(filter);
        fetchDataMaterial(filter);
    })

    function fetchDataMaterial(filter) {
        $.ajax({
            url: '/datatable-server-side/' + filter + '/data-material-mixing',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#data-material').html(response.data.html)
            }
        });
    }
</script>