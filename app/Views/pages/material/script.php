<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/material', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
            targets: 1, // Target kolom
            render: function(data, type, row, meta) {
                var btn =
                    '<a href="/material/' + data + '/edit" class="me-2 btn btn-sm btn-primary btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Data"><i class="bx bx-pencil me-0"></i></a>' +
                    '<a href="/material/' + data + '/delete" class="me-2 btn btn-sm btn-danger btn-delete" data-id-produk="' + data + '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Data"><i class="bx bx-trash me-0"></i></a>'
                return btn;
            }
        }, <?= (session('role') == 'admin_cabang') ? "{ targets: 2, visible: false }," : "" ?>],
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

    // instanse tom selest
    let tomSelectSatuan = null;
    let tomSelectJenis = null;

    // fetch data satuan
    function fetchSatuan(id = null) {

        if (tomSelectSatuan !== null) tomSelectSatuan.destroy();

        $.ajax({
            url: '/api/satuan',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#satuan_id');
                $select.empty();
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_satuan + '">' + item.nama_satuan + '</option>');
                });

                tomSelectSatuan = new TomSelect("#satuan_id", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

                if (id !== null) tomSelectSatuan.setValue(id)
            }
        });
    };

    // fetch data cabang
    function fetchJenis(id = null) {

        if (tomSelectJenis !== null) tomSelectJenis.destroy();

        $.ajax({
            url: '/api/jenis',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('#jenis_id');
                $select.empty();
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_jenis + '">' + item.nama_jenis + '</option>');
                });

                tomSelectJenis = new TomSelect("#jenis_id", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
                if (id !== null) tomSelectJenis.setValue(id)
            }
        });
    };

    $('#btn-modal-material').click(function() {
        fetchJenis();
        fetchSatuan();
    });

    // katika modal di tutup
    $('#form-data-modal').on('hidden.bs.modal', function() {
        $('#form-data').attr('action', '');
        $('#form-data')[0].reset();
        $('#form-data .form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#btn-simpan').attr('disabled', false).text('Simpan data');
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
                fetchJenis(response.data.jenis_id);
                fetchSatuan(response.data.satuan_id);
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value);
                });
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
</script>