<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/unit', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
            targets: 1, // Target kolom
            render: function(data, type, row, meta) {
                var btn =
                    '<a href="/unit/' + data + '/edit" class="me-2 btn btn-sm btn-primary btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Data"><i class="bx bx-pencil me-0"></i></a>' +
                    '<a href="/unit/' + data + '/detail" data-id="' + data + '" class="me-2 btn btn-sm btn-primary btn-detail" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Data"><i class="bx bx-info-circle me-0"></i></a>' +
                    '<a href="/unit/' + data + '/delete" class="me-2 btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Data"><i class="bx bx-trash me-0"></i></a>'
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

    table.on('draw.dt', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // katika modal di tutup
    $('#form-data-modal').on('hidden.bs.modal', function() {
        $('#form-data').attr('action', '');
        $('#form-data')[0].reset();
        $('#form-data .form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#btn-simpan').attr('disabled', false).text('Simpan data');
    });

    $('#detail-data-modal').on('hidden.bs.modal', function() {
        $('#progres-unit').html('');
    });

    // hendle save data
    $('#form-data').submit(function(e) {
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
                $('#form-data-modal').modal('hide');
                table.ajax.reload(null, false); // Reload data tanpa reset pagination
                alertMesage(response.status, response.message);
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
                $('#form-data-modal').modal('show');
                $('#form-data').attr('action', url);
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value);
                });
                $('#jumlah_panel_act').val(response.data.jumlah_panel);
                tinymce.get('detail_pengerjaan').setContent(response.data.detail_pengerjaan || '');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    })

    // hendle detail button
    table.on('click', 'tbody tr td a.btn-detail', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var id = $(this).attr('data-id');

        detailData(url, id);

    })

    function detailData(url, id) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#detail-data-modal').modal('show');
                $('#form-update-status').attr('action', '/unit/' + id + '/update-status');
                $('#btn-selesai').attr('data-href', '/unit/' + id + '/status-update');
                $('#form-add-material').attr('action', '/unit/' + id + '/add-material');
                statusUnit(id);
                materialUnit(id);
                progresStatus(id);
                riwayatUnit(id);
                $.each(response.data, function(key, value) {
                    $('#detail_' + key).html(value);
                    if (key == 'status') $('#detail_status').html((value == 0 ? 'Sedang Proses' : 'Selesai'));
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // hendle detail
    function statusUnit(id) {
        $.ajax({
            url: '/api/' + id + '/status-unit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#unit_status_harga_id');
                $select.empty();
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_unit_status_harga + '">' + item.nama_status + '</option>');
                });
            }
        });
    }

    // riwayat unit
    function riwayatUnit(id) {
        $.ajax({
            url: '/api/' + id + '/riwayat-unit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#riwayat-unit').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }

    // progres unit
    function progresStatus(id) {
        $.ajax({
            url: '/api/' + id + '/progres-status-unit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#progres-unit').html(response.data.html);
            }
        });
    }

    // material unit
    function materialUnit(id) {
        $.ajax({
            url: '/api/' + id + '/material-unit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#material-unit').html(response.data.html)
            }
        });
    }

    // update status
    $('#form-update-status').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var formData = new FormData(this); // Ambil data form
        $('#btn-update').attr('disabled', true).text('Mengpdate...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, // Jangan proses data
            contentType: false, // Jangan tetapkan tipe konten
            success: function(response) {
                alertMesage(response.status, response.message);
                $('#form-update-status')[0].reset();
                statusUnit(response.data.id_unit);
                progresStatus(response.data.id_unit);
                riwayatUnit(response.data.id_unit);
                $('#btn-update').attr('disabled', false).text('Update Status');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#btn-update').attr('disabled', false).text('Update Status');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                alertMesage(response.status, response.message);
            }
        })
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
            `<div class="row p-2" id="row-material">
                <div class="mb-3 col-sm-12 col-md-12 col-lg-4 col-12">
                    <select class="form-select form-select-sm select-material" name="material_id[]" required>${material}</select>
                </div>
                <div class="mb-3 col-sm-6 col-md-4 col-lg-2 col-6">
                    <div class="position-relative input-icon">
                        <input type="text" name="harga[]" class="form-control form-control-sm harga-material" readonly required placeholder="xxxxxx">
                        <span class="position-absolute top-50 translate-middle-y">Rp </span>
                    </div>
                </div>
                <div class="mb-3 col-sm-6 col-md-3 col-lg-2 col-6">
                    <div class="position-relative input-icon">
                        <span class="position-absolute top-50 translate-middle-y stok-material "></span>
                        <input type="text" inputmode="numeric" name="jumlah[]" class="form-control form-control-sm" id="jumlah" required style="padding-left: 2.5rem; padding-right: 1.90rem;">
                        <span class="position-absolute top-50 translate-middle-y satuan-material" style="right: 15px !important; left: unset;"></span>
                    </div>
                </div>
                <div class="mb-3 col-sm-10 col-md-4 col-lg-3 col-10">
                    <input type="text" name="detail_jumlah[]" class="form-control form-control-sm" required placeholder="Detail jumlah">
                </div>
                <div class="mb-3 col align-self-end">
                    <button type="button" class="btn btn-danger w-100 btn-sm" id="btn-del-row">-</button>
                </div>
            </div>`;
        $('#row-material').after($html);
    })

    // handle delete row
    $(document).on('click', '#btn-del-row', function() {
        $(this).closest('#row-material').remove();
    });

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

    function dataMaterial() {
        $.ajax({
            url: '/api/material',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#material_id');
                $select.empty();
                $select.append('<option hidden>-- Pilih Material --</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option data-stok="' + item.stok + '" data-satuan="' + item.nama_satuan + '" data-harga="' + item.harga + '" value="' + item.id_material + '">' + item.nama_material + '</option>');
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
        $.ajax({
            url: '/api/mekanik',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#mekanik_id');
                $select.empty();
                $select.append('<option hidden>-- Pilih Mekanik --</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_mekanik + '">' + item.nama_mekanik + '</option>');
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
                $('#form-data-modal').modal('hide');
                table.ajax.reload(null, false); // Reload data tanpa reset pagination
                alertMesage(response.status, response.message);
                detailData(response.data.url, response.data.id);
                $('#modal-material-data').modal('hide');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#btn-material').attr('disabled', false).text('Simpan data');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle buka gambar unit
    $(document).on('click', 'button#btn-gambar-unit', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-gambar');
        $('#nama-riwayat').text($(this).attr('data-riwayat'));
        $('#gambar-unit').attr('src', url);
        $('#modal-gambar-unit').modal('show');
    });

    // handle unit selesai
    $(document).on('click', 'button#btn-selesai', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-href');

        Swal.fire({
            title: 'Konfirmasi Aksi',
            text: "Apakah Anda yakin ingin mengubah status data ini menjadi selesai?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        table.ajax.reload(null, false); // Reload data tanpa reset pagination
                        progresStatus(response.data.id_unit);
                        $('#detail_status').html('Selesai');
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

    // hendle perhitungan 
    function hitungDiskon() {
        var harga = parseInt($('#harga_spp').val());
        var diskon = parseInt($('#diskon').val()) || 0;
        var total = harga - (harga * diskon / 100);
        total = Math.round(total);
        $('#jumlah_diskon').val(harga ? total : '');
    }

    function hitungPanel() {
        var jumlah_diskon = parseInt($('#jumlah_diskon').val());
        var harga_panel = parseInt($('#harga_panel').val());
        var jumlah_panel = 0;
        if (jumlah_diskon && harga_panel && harga_panel > 0) {
            jumlah_panel = jumlah_diskon / harga_panel;
            jumlah_panel_act = jumlah_panel
            jumlah_panel = Math.round(jumlah_panel * 100) / 100;
        }
        $('#jumlah_panel_act').val(jumlah_panel_act);
        $('#jumlah_panel').val(jumlah_panel > 0 ? jumlah_panel.toFixed(2) : '');
    }

    function hitungUpahMekanik() {
        var upah_mekanik = parseInt($('#upah_mekanik').val());
        var jumlah_panel = parseFloat($('#jumlah_panel_act').val());

        var total_upah = 0;
        if (!isNaN(upah_mekanik) && !isNaN(jumlah_panel)) {
            total_upah = upah_mekanik * jumlah_panel;
            total_upah = Math.round(total_upah);
            // total_upah = total_upah;
        }
        $('#total_upah_mekanik').val((total_upah > 0) ? total_upah : '');
    }
    $('#harga_spp, #diskon, #harga_panel, #upah_mekanik').on('keyup change', function() {
        hitungDiskon();
        hitungPanel();
        hitungUpahMekanik();
    });
</script>