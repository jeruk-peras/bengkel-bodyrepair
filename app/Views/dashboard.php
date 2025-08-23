<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="d-flex align-items-center table-responsive mb-3">
        <div class="me-5">
            <h6 class="mb-0">Dashboard</h6>
        </div>
        <div class="ms-auto">
            <form class="d-flex align-items-center" method="POST" action="" id="filter-form">
                <label for="tanggal_awal" class="me-2 mb-0">Tahun&nbsp;:</label>
                <select name="tahun" id="filtertahun" class="form-select form-select-sm me-2" style="min-width: 80px;">
                    <?php for ($year = (int)date('Y'); 2020 <= $year; $year--): ?>
                        <option value="<?= $year; ?>"><?= $year; ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-sm btn-primary" id="btn-filter">Filter</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-7 col-sm-6 col-lg-6 col-xl-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Penel</p>
                            <h4 class="my-1" id="total_panel"></h4>
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class="bx bx-bar-chart-alt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-6 col-xl-2">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Unit Proses</p>
                            <h4 class="my-1" id="unit_proses"></h4>
                        </div>
                        <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class="bx bxs-binoculars"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-6 col-xl-2">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Panel Proses</p>
                            <h4 class="my-1" id="panel_proses"></h4>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bx-blanket"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 col-sm-6 col-lg-6 col-xl-2">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Unit&nbsp;Selesai</p>
                            <h4 class="my-1" id="unit_selesai"></h4>
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class="bx bxs-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-6 col-xl-2">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Panel Selesai</p>
                            <h4 class="my-1" id="panel_selesai"></h4>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7 col-sm-6 col-lg-6 col-xl-6">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Upah</p>
                            <h4 class="my-1" id="total_upah"></h4>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="bx bx-chalkboard"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7 col-sm-6 col-lg-6 col-xl-6">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Pendapatkan</p>
                            <h4 class="my-1" id="total_nilai"></h4>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="bx bx-line-chart-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="pemakaian-material">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-7 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div id="chart5"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div id="chart8"></div>
                </div>
            </div>
        </div>
        <?php if (is_array(session('selected_akses'))): ?>
            <div class="col-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div id="chart4"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 mx-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Closing Mekanik</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="widget-closing"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 mx-auto">
            <h6>Panduan Filter Dashboard</h6>
            <ul>
                <li>*Filter Tahun Hanya mempengaruhi data Data Grafik Closingan Bulanan.</li>
                <li>*Data Total Panel, Unit Dalam Proses, Unit Selesi, Total Pendapatan, Grafik Penggunaan Material, Dan Closing Mekanik didapat dari unit yang belum dimasukan closing.</li>
            </ul>
        </div>
    </div>

</div>
<?= $this->include('script'); ?>
<?= $this->endSection(); ?>