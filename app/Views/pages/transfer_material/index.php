<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Transfer Data</li>
                    <li class="breadcrumb-item active" aria-current="page">Transfer Data Material</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="suplier" class="form-label">Ambil data dari</label>
                    <select name="form" id="form" class="form-select cabang-select"></select>
                </div>
                <div class="col-md-6">
                    <label for="total_harga" class="form-label">Transfer Ke Cabang</label>
                    <select name="to" id="to" class="form-select cabang-select1"></select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-outline-primary" id="btn-preview">Lihat Data</button>
                    <button type="button" class="btn btn-primary" id="btn-transfer">Transfer Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="preview-data"></div>
</div>
<?= $this->include('layout/tomselect'); ?>
<script>
    var form, to;
    form = $('#form');
    to = $('#to');

    // hendle transfer data
    $('#btn-transfer').click(function(e) {
        Swal.fire({
            title: 'Konfirmasi Aksi',
            text: "Apakah Anda yakin ingin melakukan transfer data material?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Transfer!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/transfer/transfer-meterial',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        form_cabang: form.val(),
                        to_cabang: to.val()
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

    // hendle preview data
    $('#btn-preview').click(function(e) {
        $.ajax({
            url: '/transfer/preview-meterial',
            type: 'POST',
            dataType: 'json',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                form_cabang: form.val()
            },
            success: function(response) {
                $('#preview-data').html(response.data.html);
                alertMesage(response.status, response.message);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        })
    })

    dataCabang();

    function dataCabang() {
        $.ajax({
            url: '/api/cabang',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var $select = $('.cabang-select');
                $select.empty();
                $select.append('<option value="">Pilih Cabang</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_cabang + '">' + item.nama_cabang + '</option>');
                });

                new TomSelect(".cabang-select", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

                var $select = $('.cabang-select1');
                $select.empty();
                $select.append('<option value="">Pilih Cabang</option>');
                $.each(response.data, function(index, item) {
                    $select.append('<option value="' + item.id_cabang + '">' + item.nama_cabang + '</option>');
                });

                new TomSelect(".cabang-select1", {
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection(); ?>