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
                        '<a href="/cetak/' + data + '/pemakaian-bahan" class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Print Data"><i class="bx bx-printer me-0"></i></a>' +
                        '<a href="/unit/' + data + '/edit" class="me-2 btn btn-sm btn-primary btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Data"><i class="bx bx-pencil me-0"></i></a>' +
                        '<a href="/unit/' + data + '/detail" data-id="' + data + '" class="me-2 btn btn-sm btn-primary btn-detail" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Data"><i class="bx bx-info-circle me-0"></i></a>' +
                        '<a href="/unit/' + data + '/delete" class="me-2 btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Data"><i class="bx bx-trash me-0"></i></a>'
                    return btn;
                }
            }, {
                targets: 8, // Target kolom
                render: function(data, type, row, meta) {
                    var btn = row[13] == 1 ? '<span role="button" class="badge bg-success btn-selesai px-3 w-100" data-id="' + row[1] + '">' + data + '</span>' : '<span class="badge bg-primary w-100">' + data + ' </span>'
                    return btn;
                }
            },
            <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>
        ],
        pageLength: 50,
        lengthMenu: [25, 50, 100, 'All'],
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
        },
        initComplete: function() {
            var statusColumn = this.api().column(8); // 8 = index kolom Status
            var $filterStatus = $('#filterstatus');
            $filterStatus.empty().append('<option value="">Semua Status</option>');
            statusColumn.data().unique().sort().each(function(d) {
                $filterStatus.append('<option value="' + d + '">' + d + '</option>');
            });
            $filterStatus.on('change', function() {
                statusColumn.search(this.value, {
                    exact: true
                }).draw();
            });
        }
    });

    table.on('draw.dt', function() {
        refreshTooltips();
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
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
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
                $('#harga_spp').val(formatRupiah(response.data.harga_spp));
                $('#jumlah_diskon').val(formatRupiah(response.data.jumlah_diskon));
                $('#harga_panel').val(formatRupiah(response.data.harga_panel));
                $('#upah_mekanik').val(formatRupiah(response.data.upah_mekanik));
                $('#total_upah_mekanik').val(formatRupiah(response.data.total_upah_mekanik));

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

    // hendle update unit selesai
    table.on('dblclick', 'tbody tr td span.btn-selesai', function(e) {
        var id = $(this).attr('data-id');
        $.ajax({
            url: '/unit/' + id + '/update-status-selesai',
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

    // hendle mark unit modal
    table.on('dblclick', 'tbody tr td.mark-unit', function() {
        var id = $(this).attr('data-id');
        $('#form-mark-unit').attr('action', '/unit/' + id + '/mark');
        $('#modal-mark-unit').modal('show');
    })

    // hendle save mark
    $('#form-mark-unit').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        var url = $(this).attr('action');
        $('#btn-mark-unit').attr('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                table.ajax.reload(null, false); // Reload data tanpa reset pagination
                alertMesage(response.status, response.message);
                $('#form-mark-unit').attr('action', '');
                $('#modal-mark-unit').modal('hide');
                $('#btn-mark-unit').attr('disabled', false).text('Simpan');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
                $('#btn-mark-unit').attr('disabled', false).text('Simpan');
            }
        });
    })

    // hendle perhitungan 
    function hitungDiskon() {
        var harga = $('#harga_spp').val();
        harga = resetRupiah(harga);

        var diskon = parseInt($('#diskon').val()) || 0;
        var total = harga - (harga * diskon / 100);
        total = Math.round(total);
        // pastikan total dikonversi ke string sebelum formatRupiah
        $('#jumlah_diskon').val(harga ? formatRupiah(total) : 0);
    }

    function hitungPanel() {
        var jumlah_diskon = resetRupiah($('#jumlah_diskon').val());

        var harga_panel = resetRupiah($('#harga_panel').val());

        var jumlah_panel = 0;
        if (jumlah_diskon && harga_panel && harga_panel > 0) {
            jumlah_panel = jumlah_diskon / harga_panel;
            jumlah_panel_act = jumlah_panel
            jumlah_panel = Math.round(jumlah_panel * 100) / 100;
        }
        $('#jumlah_panel_act').val(jumlah_panel_act || 0);
        $('#jumlah_panel').val(jumlah_panel > 0 ? jumlah_panel.toFixed(2) : 0);
    }

    function hitungUpahMekanik() {
        var upah_mekanik = resetRupiah($('#upah_mekanik').val());
        var jumlah_panel = parseFloat($('#jumlah_panel_act').val());

        jumlah_panel = jumlah_panel || parseFloat($('#jumlah_panel').val());

        var total_upah = 0;
        if (!isNaN(upah_mekanik) && !isNaN(jumlah_panel)) {
            total_upah = upah_mekanik * jumlah_panel;
            total_upah = Math.round(total_upah);
            // total_upah = total_upah;
        }
        $('#total_upah_mekanik').val((total_upah > 0) ? formatRupiah(total_upah) : 0);
    }
    $('#harga_spp, #diskon, #harga_panel, #upah_mekanik').on('keyup change', function() {
        hitungDiskon();
        hitungPanel();
        hitungUpahMekanik();
    });

    $('.btn-filter').click(function() {
        var f = $(this).attr('data-f');
        $('#datatable').attr('data-filter', f);
        table.ajax.reload();

        $('.btn-filter').removeClass('active');
        $(this).addClass('active');
        fetchDataStatusUnit(f);
    });

    // closing mekanik data
    $('#tab-status-unit').click(function() {
        var filter = $('#datatable').attr('data-filter');
        fetchDataStatusUnit(filter);
    })

    function fetchDataStatusUnit(filter) {
        $.ajax({
            url: '/unit/' + filter + '/status-unit',
            method: 'GET',
            success: function(response) {
                $('#data-status-unit').html(response.data.html);
                refreshTooltips();
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }
</script>