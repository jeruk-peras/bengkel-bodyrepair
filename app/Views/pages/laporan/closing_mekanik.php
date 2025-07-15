<?php $this->extend('layout/index');  ?>
<?php $this->section('content');  ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Closing Mekanik</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Laporan Closing Mekanik</h6>
                </div>
                <div class="ms-auto">
                    <form class="d-flex align-items-center" method="POST" action="" id="filter-form">
                        <?= csrf_field(); ?>
                        <label for="tanggal_awal" class="me-2 mb-0">Tanggal&nbsp;Masuk:</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control form-control-sm me-2" value="<?= esc($tanggal_awal ?? '') ?>">
                        <span class="me-2">s/d</span>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control form-control-sm me-2" value="<?= esc($tanggal_akhir ?? '') ?>">
                        <button type="submit" class="btn btn-sm btn-primary" id="btn-filter">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="data-closingan">
                <div class="text-center my-5">
                    <img src="<?= base_url('assets/images/Search-rafiki.svg'); ?>" alt="Cari Data" style="max-width:350px;" class="mb-4">
                    <h5>Silakan lakukan filter tanggal terlebih dahulu untuk melihat data closing mekanik.</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#filter-form').submit(function(e) {
        e.preventDefault();
        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();
        $('#btn-filter').attr('disabled', true).text('Filter');
        $('#data-closingan').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                alertMesage(response.status, response.message);
                $('#data-closingan').html(response.data.html);
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                $('#btn-filter').attr('disabled', false).text('Filter');
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#btn-filter').attr('disabled', false).text('Filter');
                alertMesage(response.status, response.message);
            }
        })
    })
</script>
<?php $this->endSection();  ?>