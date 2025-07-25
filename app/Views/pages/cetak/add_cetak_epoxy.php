<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Cetak</li>
                    <li class="breadcrumb-item active">Cetak Foto Epoxy</li>
                    <li class="breadcrumb-item active" aria-current="page">Add Foto Epoxy</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Form Cetak Foto Epoxy</h6>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <div class="row g-3">

                    <div class="col-md-12">
                        <label for="select_no_spp" class="form-label required">Nomor SPP</label>
                        <select name="id_unit" class="form-select"" id="select_no_spp"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="nomor_polisi" class="form-label required">Nomor Polisi</label>
                        <input type="text" class="form-control" id="nomor_polisi" readonly disabled placeholder="Nomor Polisi">
                    </div>
                    <div class="col-md-4">
                        <label for="nama_asuransi" class="form-label required">Nama Asuransi</label>
                        <input type="text" class="form-control" id="nama_asuransi" readonly disabled placeholder="Nama Asuransi">
                    </div>
                    <div class="col-md-4">
                        <label for="type_unit" class="form-label required">Type Kendaraan</label>
                        <input type="text" class="form-control" id="type_unit" readonly disabled placeholder="Type Kendaraan">
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('cetak/epoxy'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // ketika select no_spp berubah, update input lainnya
        $('#select_no_spp').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#nomor_polisi').val(selectedOption.data('nomor-polisi'));
            $('#nama_asuransi').val(selectedOption.data('nama-asuransi'));
            $('#type_unit').val(selectedOption.data('type-unit'));
        });

        dataSPP();

        function dataSPP() {

            $.ajax({
                url: '/api/no-spp',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var $select = $('#select_no_spp');
                    $select.empty().append('<option value="" hidden>-- Pilih Nomor SPP --</option>');
                    $.each(response.data, function(index, item) {
                        $select.append('<option data-nomor-polisi="' + item.nomor_polisi + '" data-nama-asuransi="' + item.nama_asuransi + '" data-type-unit="' + item.model_unit + '" value="' + item.id_unit + '">' + item.nomor_spp + ' | ' + item.nomor_polisi + ' | ' + item.model_unit + '</option>');
                    });

                    let tomSelectSPP = new TomSelect("#select_no_spp", {
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
                    alertMesage(response.status, response.message);
                    window.location.href = response.data.redirect;
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
        });
    });
</script>
<?= $this->endSection(); ?>