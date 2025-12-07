<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Daftar Kasbon Karyawan</li>
                    <li class="breadcrumb-item active" aria-current="page">Persetujuan Kasbon</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Kasbon Karyawan</h6>
                </div>
                <div class="ms-auto">
                    <button data-type="1" class="btn btn-sm btn-primary ms-2 px-3 btn-pengajuan"><i class="bx bx-check"></i> Terima</button>
                    <button data-type="0" class="btn btn-sm btn-primary ms-2 px-3 btn-pengajuan"><i class="bx bx-x"></i> Tolak</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="" method="post" id="form-pengajuan">
                    <?= csrf_field(); ?>
                    <table class="table align-middle mb-0" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th><input type="checkbox" class="form-check-input" id="select-all"></th>
                                <th>Cabang</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th style="width: 12%;">Disetujui</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($pengajuan as $row): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><input type="checkbox" class="form-check-input select-data" name="kasbon[<?= $row['id_kasbon']; ?>]" value="<?= $row['id_kasbon']; ?>"></td>
                                    <td><?= $row['nama_cabang']; ?></td>
                                    <td><?= $row['nama_lengkap']; ?></td>
                                    <td><?= $row['tanggal']; ?></td>
                                    <?php
                                    $status = strtolower($row['jenis']);
                                    $badgeClass = 'bg-secondary';
                                    if ($status === 'bayar') {
                                        $badgeClass = 'bg-success';
                                    } elseif ($status === 'pinjam') {
                                        $badgeClass = 'bg-warning';
                                    }
                                    ?>
                                    <td><span class="badge <?= $badgeClass ?> px-3"><?= strtoupper($row['jenis']); ?></span></td>
                                    <td>Rp<?= number_format(str_replace('-', '', $row['jumlah'])); ?></td>
                                    <td>
                                        <div class="position-relative input-icon">
                                            <input type="text" name="disetujui[<?= $row['id_kasbon']; ?>]" inputmode="numeric" onclick="return this.select()" class="form-control form-control-sm text-end rupiah row-disetujui" value="<?= number_format($row['jumlah'], 0, '.', '.'); ?>">
                                            <span class="position-absolute top-50 translate-middle-y">Rp</span>
                                        </div>
                                    </td>
                                    <td><?= $row['alasan']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.btn-pengajuan').click(function(e) {
            e.preventDefault();
            var url, formData;
            url = $('#form-pengajuan').attr('action');
            formData = $('#form-pengajuan').serializeArray();
            formData.push({
                'name': 'status',
                'value': $(this).attr('data-type')
            })

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    alertMesage(response.status, response.message);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                    // window.location.reload();
                }
            })
        })

        $('#select-all').on('click', function() {
            var checked = $(this).prop('checked');
            $('.select-data').prop('checked', checked).trigger('change');
        });

        $(document).on('change', '.select-data', function() {
            var total = $('.select-data').length;
            var checked = $('.select-data:checked').length;
            var $selectAll = $('#select-all');

            if (checked === 0) {
                $selectAll.prop('checked', false).prop('indeterminate', false);
            } else if (checked === total) {
                $selectAll.prop('checked', true).prop('indeterminate', false);
            } else {
                $selectAll.prop('checked', false).prop('indeterminate', true);
            }
        });

        $('.select-data').first().trigger('change');
    });
</script>
<?= $this->endSection(); ?>