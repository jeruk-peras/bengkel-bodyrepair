<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="http://localhost:8800/dashboard"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Gaji Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Gaji</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="/gaji-karyawan" class="btn btn-sm btn-primary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="periode" class="form-label">Periode</label>
                    <input type="text" class="form-control" id="periode" readonly="" disabled="" value="<?= $detailgaji['periode']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="text" class="form-control" id="tanggal" readonly="" disabled="" value="<?= $detailgaji['tanggal']; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <?php if (session()->get('role') == 'Finance' && $detailgaji['status'] == 0): ?>
                        <a href="<?= base_url('closing'); ?>" class="btn btn-sm btn-primary btn-lock"><i class="bx bx-lock-open"></i> Lock Data</a>
                    <?php elseif (session()->get('role') == 'Finance' && $detailgaji['status'] == 1): ?>
                        <a href="<?= base_url('closing'); ?>" class="btn btn-sm btn-primary btn-lock"><i class="bx bx-lock"></i> Locked</a>
                    <?php endif;  ?>
                </div>
                <div class="ms-auto">
                    <a href="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/print" target="_blank" class="btn btn-sm btn-primary"><i class="bx bx-printer"></i> Print Data</a>
                    <a href="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/export" class="btn btn-sm btn-primary"><i class="bx bx-export"></i> Export Data</a>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-import"></i> Import Data</button>
                </div>
            </div>
            <div class="table-responsive" id="detail-gaji">
                <div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="form-data-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/import" method="post" id="form-data" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="file_excel" class="form-label required">Import Data</label>
                            <input type="file" name="file_excel" class="form-control" id="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" placeholder="file_excel">
                            <div class="invalid-feedback" id="invalid_file_excel"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (session()->get('role') == 'Finance'):  ?>
    <div class="modal fade" id="lock-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lock Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/lock" method="post" id="form-lock-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="password">
                                <div class="invalid-feedback" id="invalid_password"></div>
                                <div class="form-text">* Untuk lock dan unlock data gaji masukan password akun Finance</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function() {

        function load() {

            $.ajax({
                url: '/gaji-karyawan/<?= $detailgaji['id_gaji']; ?>/detail',
                type: 'POST',
                dataType: 'json',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                },
                success: function(response) {
                    console.log(response)
                    $('#detail-gaji').html(response.data.html);
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                }
            })
        }
        load();

        // handle import file upload
        $('#form-data').submit(function(e) {
            e.preventDefault();
            var $form = $(this);
            var url = $form.attr('action');
            var $btn = $form.find('#btn-simpan');
            var formElement = $form[0];
            var formData = new FormData(formElement);

            $btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#form-data-modal').modal('hide');
                    $form[0].reset();
                    $form.find('.form-control').removeClass('is-invalid');
                    $form.find('.invalid-feedback').text('');
                    $btn.prop('disabled', false).text('Simpan Data');
                    alertMesage(response.status, response.message);
                    // refresh detail table
                    load();
                },
                error: function(xhr) {
                    var response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (err) {
                        response = { status: 'error', message: 'Terjadi kesalahan pada server' };
                    }

                    $form.find('.form-control').removeClass('is-invalid');
                    $form.find('.invalid-feedback').text('');
                    $btn.prop('disabled', false).text('Simpan Data');

                    if (response.data) {
                        $.each(response.data, function(key, value) {
                            // prefer id selector, fallback to name selector
                            var $field = $('#' + key);
                            if (!$field.length) {
                                $field = $form.find('[name="' + key + '"]');
                            }
                            $field.addClass('is-invalid');
                            $form.find('#invalid_' + key).text(value).show();
                        });
                    }

                    alertMesage(response.status, response.message);
                }
            });
        });

        <?php if (session()->get('role') == 'Finance'): ?>
            // hendle lock data
            $('a.btn-lock').click(function(e) {
                e.preventDefault();
                $('#lock-modal').modal('show');
            })

            $('#form-lock-data').submit(function(e) {
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
                        $('#lock-modal').modal('hide');
                        alertMesage(response.status, response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 300)
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        $('#form-lock-data .form-control').removeClass('is-invalid');
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
        <?php endif; ?>
    })
</script>
<?= $this->endSection(); ?>