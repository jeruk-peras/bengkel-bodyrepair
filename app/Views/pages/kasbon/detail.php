<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Daftar Kasbon Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Kasbon Karyawan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="/kasbon" class="btn btn-sm btn-primary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Data Kasbon - <?= $karyawan['nama_lengkap']; ?></h6>
                </div>
                <div class="ms-auto">
                    <ul class="nav nav-pills flex-nowrap" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-3 py-1 active" data-bs-toggle="pill" href="#daftar-kasbon" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Daftar Kasbon</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link px-3 py-1" data-bs-toggle="pill" href="#daftar-pengajuan" id="tab-pengajuan" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-title">Histori Pengajuan</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Pengajuan</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="daftar-kasbon" role="tabpanel">

                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kasbon</th>
                                    <th>Bayar</th>
                                    <th>Utang</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($kasbon as $row): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['tanggal']; ?></td>
                                        <td>Rp<?= number_format($row['pinjam']); ?></td>
                                        <td>Rp<?= number_format($row['bayar']); ?></td>
                                        <td>Rp<?= number_format($row['utang']); ?></td>
                                        <td><?= $row['keterangan']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="tab-pane fade" id="daftar-pengajuan" role="tabpanel">
                    <div class="table-responsive" id="data-pengajuan"></div>
                </div>
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
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label required">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= date('Y-m-d'); ?>">
                            <div class="invalid-feedback" id="invalid_tanggal"></div>
                        </div>
                        <div class="col-md-5">
                            <label for="jumlah" class="form-label required">Jumlah Kasbon</label>
                            <input type="text" inputmode="numeric" name="jumlah" class="form-control" id="jumlah">
                            <div class="invalid-feedback" id="invalid_jumlah"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="jenis" class="form-label required">Jenis</label>
                            <select name="jenis" class="form-select" id="jenis">
                                <option value="pinjam" selected>Pinjam</option>
                                <option value="bayar">Bayar</option>
                            </select>
                            <div class="invalid-feedback" id="invalid_jenis"></div>
                        </div>
                        <div class="col-12">
                            <label for="alasan" class="form-label required">Alasan Kasbon</label>
                            <textarea type="text" name="alasan" class="form-control" id="alasan"></textarea>
                            <div class="invalid-feedback" id="invalid_alasan"></div>
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
                $('#form-data-modal').modal('hide');
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

    $('#tab-pengajuan').click(function(){
        load();
    })

    function load() {
        $.ajax({
            url: '/kasbon/<?= $karyawan['id_karyawan']; ?>/pengajuan',
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
<?= $this->endSection(); ?>