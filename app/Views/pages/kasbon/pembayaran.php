<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Kasbon Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran Kasbon</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Pembayaran Kasbon</h6>
                </div>
                <div class="ms-auto"></div>
            </div>
        </div>
        <div class="card-body">

            <form action="/kasbon/pembayaran/load" id="form-load-pembayaran" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-4">
                        <label for="cabang_id" class="form-label">Cabang</label>
                        <select name="cabang_id" class="form-control form-control-sm" id="cabang_id"></select>
                    </div>
                    <div class="col-4">
                        <label for="periode-gaji" class="form-label">Periode Gaji</label>
                        <select name="periode" class="form-control form-control-sm" id="periode-gaji">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="komponen-gaji" class="form-label">Komponen Gaji</label>
                        <select name="komponen_id" class="form-control form-control-sm" id="komponen-gaji">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="d-flex align-items-center mt-2">
                <div></div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-sm btn-primary ms-2 px-3" id="btn-load-data"><i class="bx bx-refresh"></i> Load Data</button>
                    <button type="button" class="btn btn-sm btn-primary ms-2 px-3" disabled id="btn-save-data"> Simpan Data</button>
                </div>
            </div>
            <form action="" method="post" id="form-bayar">
                <?= csrf_field(); ?>
                <div class="table-responsive mt-4" id="load-data"></div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('layout/tomselect'); ?>

<script>
    $(document).ready(function() {

        $('#btn-load-data').click(function() {
            var formData = $('#form-load-pembayaran');
            var url = formData.attr('action');
            formData = formData.serializeArray();

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    alertMesage(response.status, response.message);

                    $('#load-data').html(response.data.html);
                    $('#btn-save-data').attr('disabled', false);
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                }
            })
        })

        $('#btn-save-data').click(function() {

            var formData = $('#form-bayar');
            var url = formData.attr('action');

            formData = formData.serializeArray();

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    alertMesage(response.status, response.message);

                    setTimeout(function() {
                        window.location.reload();
                    }, 700)
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                }
            })
        })


        // instanse tom selest
        let tomSelectCabang = null;
        let tomSelectPeriode = null;
        let tomSelectKomponen = null;

        dataCabang();
        dataPeriode();
        dataKomponen();

        function dataCabang(id = null) {
            if (tomSelectCabang !== null) tomSelectCabang.destroy();
            $.ajax({
                url: '/api/cabang',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var $select = $('#cabang_id');
                    $select.empty();
                    $select.append('<option value="">-- Pilih --</option>');
                    $.each(response.data, function(index, item) {
                        $select.append('<option value="' + item.id_cabang + '">' + item.nama_cabang + '</option>');
                    });

                    tomSelectCabang = new TomSelect("#cabang_id", {
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });
                    if (id !== null) tomSelectCabang.setValue(id)
                }
            })
        }

        function dataKomponen(id = null) {
            if (tomSelectKomponen !== null) tomSelectKomponen.destroy();
            $.ajax({
                url: '/api/komponen-gaji',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var $select = $('#komponen-gaji');
                    $select.empty();
                    $select.append('<option value="">-- Pilih --</option>');
                    $.each(response.data, function(index, item) {
                        $select.append('<option value="' + item.id_komponen_gaji + '">' + item.nama_komponen_gaji + '</option>');
                    });

                    tomSelectKomponen = new TomSelect("#komponen-gaji", {
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });
                    if (id !== null) tomSelectKomponen.setValue(id)
                }
            })
        }

        function dataPeriode(id = null) {
            if (tomSelectPeriode !== null) tomSelectPeriode.destroy();
            $.ajax({
                url: '/api/periode-gaji',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var $select = $('#periode-gaji');
                    $select.empty();
                    $select.append('<option value="">-- Pilih --</option>');
                    $.each(response.data, function(index, item) {
                        $select.append('<option value="' + item.id_gaji + '">' + item.periode + '</option>');
                    });

                    tomSelectPeriode = new TomSelect("#periode-gaji", {
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });
                    if (id !== null) tomSelectPeriode.setValue(id)
                }
            })
        }

    })
</script>
<?= $this->endSection(); ?>