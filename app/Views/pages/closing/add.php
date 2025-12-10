<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Closing</li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Closing</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Form Closingan</h6>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label required">Tanggal Closing</label>
                        <input type="datetime-local" name="tanggal" class="form-control" id="tanggal" placeholder="Tanggal" value="<?= date('Y-m-d H:i'); ?>">
                        <div class="invalid-feedback" id="invalid_tanggal"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="periode_closing" class="form-label required">Periode Closing</label>
                        <select name="periode_closing" class="form-select" id="periode_closing">
                            <?php $now = new DateTime('first day of this month');
                            $start = (clone $now)->modify('-3 months');
                            $end = (clone $now)->modify('+4 months'); ?>
                            <?php while ($start <= $end) :
                                $periode = $start->format("F - Y");
                                $start->modify("+1 month"); ?>
                                <option value="<?= $periode; ?>"><?= $periode; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="invalid-feedback" id="invalid_periode_closing"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" id="catatan"></textarea>
                        <div class="invalid-feedback" id="invalid_harga"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('closing/'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
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
    })
</script>
<?= $this->endSection(); ?>