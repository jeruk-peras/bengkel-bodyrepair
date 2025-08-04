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
                targets: 1, // Target kolom
                render: function(data, type, row, meta) {
                    var btn =
                        '<button data-id="' + data + '" class="me-2 btn btn-sm btn-primary btn-add-material" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Material"><i class="bx bx-plus me-0"></i></button>' +
                        '<a href="/material-mixing/' + data + '/detail" class="me-2 btn btn-sm btn-primary btn-detail" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Data"><i class="bx bx-info-circle me-0"></i></a>'
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
        dataMaterial();
        dataMekanik();
    });

    // add row
    $('#btn-add-row').click(function() {
        var material = $('#material_id').html();
        var $html =
            `<div class="row mt-2 row-material" id="row-material">
                <div class="col-sm-12 col-md-12 col-lg-6 col-12" style="padding-right: 5px !important;">
                    <select class="form-select form-select-sm select-material tom-select" name="material_id[]" required>${material}</select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2 col-6" style="padding: 0 5px 0 5px !important;"> 
                    <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        <input type="text" name="harga[]" class="form-control form-control-sm harga-material" readonly required placeholder="xxxxxx"  style="padding-left: 2.5rem; padding-right: 1.90rem;">
                        <span class="position-absolute top-50 translate-middle-y satuan-material" style="right: 15px !important; left: unset;"></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-1 col-6" style="padding: 0 5px 0 5px !important;">
                    <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y stok-material" style="left: 6px !important;"></span>
                        <input type="text" inputmode="numeric" name="jumlah[]" class="form-control form-control-sm" id="jumlah" required>
                    </div>
                </div>
                <div class="col-sm-10 col-md-4 col-lg-2 col-10" style="padding: 0 5px 0 5px !important;">
                    <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y">Rp</span>
                        <input type="text" name="total_harga[]" class="form-control form-control-sm" id="total_harga" required readonly style="padding-left: 2.5rem;">
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
        $(this).closest('#row-material').find('.harga-material').val(harga);

        var satuan = $(this).find('option:selected').attr('data-satuan');
        $(this).closest('#row-material').find('.satuan-material').text(satuan);

        var stok = $(this).find('option:selected').attr('data-stok');
        $(this).closest('#row-material').find('.stok-material').text(stok + '/');
    })

    // buat validasi sisa stok dengan jumlah
    $(document).on('keyup change', '.select-material, .harga-material, #jumlah', '.satuan-material', function() {
        var $row = $(this).closest('#row-material');
        var stok = parseInt($row.find('.stok-material').text()) || 0;
        var jumlah = parseInt($row.find('#jumlah').val()) || 0;

        if (jumlah > stok) {
            $row.find('#jumlah').val(stok); // Reset jumlah ke stok maksimum
        }
    });

    $(document).on('keyup change', '#jumlah', function() {
        var $row = $(this).closest('#row-material');
        var harga = parseInt($row.find('.harga-material').val()) || 0;
        var jumlah = parseFloat($row.find('#jumlah').val()) || 0;

        total_harga = harga * jumlah;
        console.log(jumlah, harga, total_harga)

        $row.find('#total_harga').val(total_harga);
    });

    // instance tom select
    let tomSelectMaterial = null;
    let tomSelectMekanik = null;

    function dataMaterial() {

        if (tomSelectMaterial !== null) tomSelectMaterial.destroy();

        $.ajax({
            url: '/api/material',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#material_id');
                $select.empty().append('<option value="">Pilih opsi...</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option data-stok="' + item.stok + '" data-satuan="' + item.nama_satuan + '" data-harga="' + item.harga + '" value="' + item.id_material + '">' + item.nama_material + '</option>');
                });

                tomSelectMaterial = new TomSelect("#material_id", {
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

    function dataMekanik() {
        if (tomSelectMekanik !== null) tomSelectMekanik.destroy();

        $.ajax({
            url: '/api/mekanik',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#mekanik_id');
                $select.empty().append('<option value="" hidden>-- Pilih Mekanik --</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_mekanik + '">' + item.nama_mekanik + '</option>');
                });

                tomSelectMekanik = new TomSelect("#mekanik_id", {
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
                alertMesage(response.status, response.message);
                $('#modal-material-data').modal('hide');
                $('#form-add-material').removeClass('is-invalid');

                $('#form-add-material')[0].reset();
                $('.row-material').not(':first').remove(); // Hapus semua baris kecuali yang pertama
                $('.row-material').eq(0).find('input, select').val('').trigger('change'); // Kosongkan input dari baris pertama
                $('.row-material .stok-material').text('');
                $('#btn-material').attr('disabled', false).text('Simpan data');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-add-material .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
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

    $('.btn-filter').click(function() {
        var f = $(this).attr('data-f');
        $('#datatable').attr('data-filter', f);
        table.ajax.reload();

        $('.btn-filter').removeClass('active');
        $(this).addClass('active');
    })
</script>