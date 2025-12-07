<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/kasbon', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
            targets: 1, // Target kolom
            render: function(data, type, row, meta) {
                var btn =
                    '<a href="/kasbon/' + data + '/detail" class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Data"><i class="bx bx-info-circle me-0"></i></a>'
                return btn;
            }
        }, <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>],
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
    
    $('#tab-pengajuan').click(function(){
        load();
    })

    function load() {
        $.ajax({
            url: '/kasbon/pengajuan',
            type: 'POST',
            dataType: 'json',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            },
            success: function(response) {
                $('#data-pengajuan').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    }
</script>