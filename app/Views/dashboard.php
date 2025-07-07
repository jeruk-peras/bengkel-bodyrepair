<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Sales Overview</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-0">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Order Status</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-0">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->


    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="">
                        <div id="chart3" style="height:250px;"></div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Apple <span class="badge bg-danger rounded-pill">20</span>
                    </li>
                    <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Samsung <span class="badge bg-primary rounded-pill">15</span>
                    </li>
                    <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Nokia <span class="badge bg-success rounded-pill">30</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-3">
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">Total Orders</p>
                                            <h5 class="my-0">8052</h5>
                                        </div>
                                        <div class="text-primary ms-auto font-30"><i class='bx bx-cart-alt'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart4"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-success">+25%</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">Total Revenue</p>
                                            <h5 class="my-0">$6.2K</h5>
                                        </div>
                                        <div class="text-danger ms-auto font-30"><i class='bx bx-dollar'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart5"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-success">+15%</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">New Users</p>
                                            <h5 class="my-0">1.3K</h5>
                                        </div>
                                        <div class="text-success ms-auto font-30"><i class='bx bx-group'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart6"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-danger">-10%</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">Sold Items</p>
                                            <h5 class="my-0">956</h5>
                                        </div>
                                        <div class="text-warning ms-auto font-30"><i class='bx bx-beer'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart7"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-danger">-14%</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">Total Visits</p>
                                            <h5 class="my-0">12M</h5>
                                        </div>
                                        <div class="text-info ms-auto font-30"><i class='bx bx-camera-movie'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart8"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-success">+28%</span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 overflow-hidden mb-0 shadow-none border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary font-14">Total Returns</p>
                                            <h5 class="my-0">178</h5>
                                        </div>
                                        <div class="ms-auto font-30"><i class='bx bx-refresh'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" id="chart9"></div>
                                <div class="position-absolute end-0 bottom-0 m-2"><span class="text-success">+35%</span></div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>

    </div><!--end row-->


    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8">
            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Top Selling Country</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dashboard-map" style="height: 250px"></div>
                    <hr>
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="country-icon">
                                <img src="assets/images/county/01.png" width="35" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-2">United States <span class="float-end">50%</span></p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="width: 50%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="country-icon">
                                <img src="assets/images/county/02.png" width="35" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-2">England <span class="float-end">65%</span></p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-deepblue" role="progressbar" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="country-icon">
                                <img src="assets/images/county/03.png" width="35" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-2">England <span class="float-end">75%</span></p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-ohhappiness" role="progressbar" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="country-icon">
                                <img src="assets/images/county/04.png" width="35" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-2">England <span class="float-end">85%</span></p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-orange" role="progressbar" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="country-icon">
                                <img src="assets/images/county/05.png" width="35" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-2">England <span class="float-end">95%</span></p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-blues" role="progressbar" style="width: 95%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 col-xl-4">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div>
                            <p class="mb-0 text-secondary font-14">Page Views</p>
                            <h5 class="my-0">2050</h5>
                        </div>
                        <div class="ms-auto font-30"><i class='bx bx-bookmark-alt'></i>
                        </div>
                    </div>
                    <div class="chart-container-5">
                        <canvas id="chart10"></canvas>
                    </div>
                </div>
            </div>
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div>
                            <p class="mb-0 text-secondary font-14">Bounce Rate</p>
                            <h5 class="my-0">24.5%</h5>
                        </div>
                        <div class="ms-auto font-30"><i class='bx bx-line-chart'></i>
                        </div>
                    </div>
                    <div class="chart-container-5">
                        <canvas id="chart11"></canvas>
                    </div>
                </div>
            </div>

            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div>
                            <p class="mb-0 text-secondary font-14">Total Cliks</p>
                            <h5 class="my-0">8945</h5>
                        </div>
                        <div class="ms-auto font-30"><i class='bx bx-heart'></i>
                        </div>
                    </div>
                    <div class="chart-container-5">
                        <canvas id="chart12"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div><!--End Row-->


    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Recent Orders</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Photo</th>
                            <th>Product ID</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Shipping</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Iphone 5</td>
                            <td><img src="assets/images/products/01.png" class="product-img-2" alt="product img"></td>
                            <td>#9405822</td>
                            <td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span></td>
                            <td>$1250.00</td>
                            <td>03 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Earphone GL</td>
                            <td><img src="assets/images/products/02.png" class="product-img-2" alt="product img"></td>
                            <td>#8304620</td>
                            <td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span></td>
                            <td>$1500.00</td>
                            <td>05 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>HD Hand Camera</td>
                            <td><img src="assets/images/products/03.png" class="product-img-2" alt="product img"></td>
                            <td>#4736890</td>
                            <td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span></td>
                            <td>$1400.00</td>
                            <td>06 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 70%"></div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Clasic Shoes</td>
                            <td><img src="assets/images/products/04.png" class="product-img-2" alt="product img"></td>
                            <td>#8543765</td>
                            <td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span></td>
                            <td>$1200.00</td>
                            <td>14 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sitting Chair</td>
                            <td><img src="assets/images/products/06.png" class="product-img-2" alt="product img"></td>
                            <td>#9629240</td>
                            <td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span></td>
                            <td>$1500.00</td>
                            <td>18 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hand Watch</td>
                            <td><img src="assets/images/products/05.png" class="product-img-2" alt="product img"></td>
                            <td>#8506790</td>
                            <td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span></td>
                            <td>$1800.00</td>
                            <td>21 Feb 2020</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 40%"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>