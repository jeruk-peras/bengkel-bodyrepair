<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Cetak</li>
                    <li class="breadcrumb-item active" aria-current="page">Cetak Slip Gaji</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Daftar Cetak Slip Gaji</h6>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <div>
                        <label class="mb-0">Filter Periode : </label>
                    </div>
                    <div style="min-width: 200px;">
                        <select name="periode" id="filterperiode" class="form-select form-select-sm"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatable" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Cabang</th>
                            <th>Peiode</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false, // Set true agar bisa di sorting
        ajax: {
            url: '/datatable-server-side/slip-gaji', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
            targets: 1, // Target kolom
            render: function(data, type, row, meta) {
                var btn =
                    '<a href="/gaji-karyawan/' + data + '/' + row[8] + '/printgaji" target="_blank" class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Print Data"><i class="bx bx-printer me-0"></i></a>'
                return btn;
            }
        }, <?= is_array(session('selected_akses')) ? "" : "{ targets: 2, visible: false }," ?>],
        pageLength: 25,
        lengthMenu: [25, 50, 100, 'All'],
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
        },
        initComplete: function() {
            var statusColumn = this.api().column(3); // 3 = index kolom Status
            var $filterperiode = $('#filterperiode');
            $filterperiode.empty().append('<option value="">Semua Periode</option>');
            statusColumn.data().unique().sort().each(function(d) {
                $filterperiode.append('<option value="' + d + '">' + d + '</option>');
            });
            $filterperiode.on('change', function() {
                statusColumn.search(this.value, {
                    exact: true
                }).draw();
            });
        }
    });

    table.on('draw.dt', function() {
        refreshTooltips();
    });
</script>
<?= $this->endSection(); ?>