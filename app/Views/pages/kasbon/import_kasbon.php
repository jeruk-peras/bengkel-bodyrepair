<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Kasbon Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Import Pengajuan Kasbon</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Import Pengajuan Kasbon</h6>
                </div>
                <div class="ms-auto"></div>
            </div>
        </div>
        <div class="card-body">

            <form action="/kasbon/import/load" id="form-import" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <label for="import_kasbon" class="form-label">Upload File</label>
                <input type="file" name="file_excel" class="form-control" id="import_kasbon">
            </form>

            <div class="d-flex align-items-center mt-2">
                <div>
                    <a href="/kasbon/import/template" class="mb-0">Template Import Kasbon.xlsx</a>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-sm btn-primary ms-2 px-3" id="btn-load-data"><i class="bx bx-refresh"></i> Load Data</button>
                    <button type="button" class="btn btn-sm btn-primary ms-2 px-3" disabled id="btn-import-data"><i class="bx bx-download"></i> Import Data</button>
                </div>
            </div>
            <form action="" method="post" id="form-data-import">
                <?= csrf_field(); ?>
                <div class="table-responsive mt-4" id="load-data"></div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#btn-load-data').click(function() {
            var file_data = $('#import_kasbon').prop('files')[0];
            var form_data = new FormData();
            form_data.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            form_data.append('file_excel', file_data);

            $.ajax({
                url: '/kasbon/import/load',
                // dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('#load-data').html(response.data.html);

                    $('#btn-import-data').attr('disabled', false);
                }
            });
        });

        $('#btn-import-data').click(function() {

            var formData = $('#form-data-import');
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
    })
</script>
<?= $this->endSection(); ?>