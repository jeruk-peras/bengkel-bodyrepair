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
            },
            <?= (session('role') == 'admin_cabang') ? "{ targets: 2, visible: false }," : "" ?>
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
                fetchAsuransi(response.data.asuransi_id);
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value);
                });
                $('#jumlah_panel').val(parseFloat(response.data.jumlah_panel).toFixed(2));
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
                $('#detail_jumlah_panel').text(parseFloat(response.data.jumlah_panel).toFixed(2));

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

    // instanse tom select
    let tomSelectAsuransi = null;

    // hendle fetch data asurnsi untuk select
    function fetchAsuransi(id) {
        if (tomSelectAsuransi !== null) tomSelectAsuransi.destroy();
        $.ajax({
            url: '/api/asuransi',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#asuransi_id');
                $select.empty();
                $select.append('<option value="">None</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_asuransi + '">' + item.nama_asuransi + '</option>');
                });

                tomSelectAsuransi = new TomSelect("#asuransi_id", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

                if (id !== null) tomSelectAsuransi.setValue(id)
            },
            error: function() {

            }
        })
    }

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