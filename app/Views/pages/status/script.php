<script src="<?= base_url(); ?>assets/plugins/jquery-ui-1.14.1/jquery-ui.js"></script>
<script>
    // sortable
    $(document).ready(function() {
        $('#table-sortable tbody').sortable({
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if ($(this).attr('data-order') !== (index + 1)) {
                        $(this).attr('data-order', (index + 1)).addClass('new-posision')
                    }
                })

                savePosisiHendler();
            }
        });

        function savePosisiHendler() {
            var baseURL = $('#table-sortable').attr('data-postURL')
            var posisi = []
            $('.new-posision').each(function() {
                posisi.push({
                    id: $(this).attr('data-primary'),
                    order: $(this).attr('data-order')
                })
                $(this).removeClass('new-posision')
            })

            $.ajax({
                url: baseURL,
                method: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    posisi
                },
                success: function(respons) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 500)
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 800)
                }
            })
        }
    })

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
                alertMesage(response.status, response.message);
                window.location.reload();
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
                window.location.reload();
            }
        })
    })

    // hendle edit button
    $(document).on('click', 'tbody tr td a.btn-edit', function(e) {
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
                $('#harga_status').val(formatRupiah(response.data.harga_status));
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
                window.location.reload();
            }
        });
    })

    // hendle delete button
    $(document).on('click', 'tbody tr td a.btn-delete', function(e) {
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
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        alertMesage(response.status, response.message);
                        window.location.reload();
                    }
                });
            }
        });
    })
</script>