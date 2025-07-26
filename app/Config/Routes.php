<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// routes
$routes->get('/', 'AccountController::loginPage');
$routes->post('/', 'AccountController::validLogin');
$routes->get('/login', 'AccountController::loginPage');
$routes->post('/login', 'AccountController::validLogin');
$routes->get('/logout', 'AccountController::logout');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/dashboard/test', 'DashboardController::test');

// routes side server
$routes->group('/api', function ($routes) {
    $routes->get('cabang', 'ServerSideController::fetchCabang');
    $routes->get('satuan', 'ServerSideController::fetchSatuan');
    $routes->get('jenis', 'ServerSideController::fetchJenis');
    $routes->get('asuransi', 'ServerSideController::fetchAsuransi');
    $routes->get('material', 'ServerSideController::fetchMaterial', ['filter' => ['selectCabang']]);
    $routes->get('mekanik', 'ServerSideController::fetchMekanik', ['filter' => ['selectCabang']]);
    $routes->get('(:num)/status-unit', 'ServerSideController::fetchStatusUnit/$1');
    $routes->get('(:num)/progres-status-unit', 'ServerSideController::fetchProsesStatusUnit/$1');
    $routes->get('(:num)/material-unit', 'ServerSideController::fetchMaterialUnit/$1');
    $routes->get('(:num)/riwayat-unit', 'ServerSideController::fetchRiwayatUnit/$1');
    $routes->get('no-spp', 'ServerSideController::fetchNoSPP');
    $routes->get('(:num)/cetak-foto', 'ServerSideController::fetchCetakFoto/$1');
    $routes->post('(:num)/cetak-foto/delete', 'ServerSideController::deleteCetakFoto/$1');
});

// routes dashboard
$routes->get('/dashboard/grafik-pendapatan', 'DashboardController::grafikPendapatan');
$routes->get('/dashboard/grafik-bulanan', 'DashboardController::grafikPendapatanPerbulan');
$routes->post('/dashboard/grafik-material', 'DashboardController::grafikMaterial');
$routes->post('/dashboard/widget-data', 'DashboardController::widgetData');
$routes->post('/dashboard/widget-closing', 'DashboardController::widgetClosing');


// routes side server
$routes->group('/datatable-server-side', function ($routes) {
    $routes->post('cabang', 'ServerSideController::cabang');
    $routes->post('users', 'ServerSideController::users');
    $routes->post('admin-cabang', 'ServerSideController::admin');
    $routes->post('mekanik', 'ServerSideController::mekanik');
    $routes->post('jenis', 'ServerSideController::jenis');
    $routes->post('asuransi', 'ServerSideController::asuransi');
    $routes->post('satuan', 'ServerSideController::satuan');
    $routes->post('status', 'ServerSideController::status');
    $routes->post('biaya', 'ServerSideController::biaya');
    $routes->post('material', 'ServerSideController::material');
    $routes->post('material-masuk', 'ServerSideController::materialMasuk');
    $routes->post('unit', 'ServerSideController::unit');
    $routes->post('epoxy', 'ServerSideController::epoxy');
    $routes->post('gandeng', 'ServerSideController::gandeng');
});


// routes cabang 
$routes->group('/cabang', function ($routes) {
    $routes->get('/', 'CabangController::index');
    $routes->post('/', 'CabangController::save');

    $routes->get('(:num)/edit', 'CabangController::edit/$1');
    $routes->post('(:num)/edit', 'CabangController::update/$1');

    $routes->post('(:num)/delete', 'CabangController::delete/$1');
});

// routes Jenis 
$routes->group('/jenis', function ($routes) {
    $routes->get('/', 'JenisController::index');
    $routes->post('/', 'JenisController::save');

    $routes->get('(:num)/edit', 'JenisController::edit/$1');
    $routes->post('(:num)/edit', 'JenisController::update/$1');

    $routes->post('(:num)/delete', 'JenisController::delete/$1');
});

// routes Asuransi 
$routes->group('/asuransi', function ($routes) {
    $routes->get('/', 'AsuransiController::index');
    $routes->post('/', 'AsuransiController::save');

    $routes->get('(:num)/edit', 'AsuransiController::edit/$1');
    $routes->post('(:num)/edit', 'AsuransiController::update/$1');

    $routes->post('(:num)/delete', 'AsuransiController::delete/$1');
});

// routes Satuan 
$routes->group('/satuan', function ($routes) {
    $routes->get('/', 'SatuanController::index');
    $routes->post('/', 'SatuanController::save');

    $routes->get('(:num)/edit', 'SatuanController::edit/$1');
    $routes->post('(:num)/edit', 'SatuanController::update/$1');

    $routes->post('(:num)/delete', 'SatuanController::delete/$1');
});

// routes Users 
$routes->group('/users', function ($routes) {
    $routes->get('/', 'UsersController::index');
    $routes->post('/', 'UsersController::save');

    $routes->get('akses', 'UsersController::akses');
    $routes->get('akses-add/(:num)', 'UsersController::akses_add/$1');
    $routes->post('akses-add/(:num)', 'UsersController::akses_save/$1');

    $routes->post('akses/select', 'AccountController::selectAksess');

    $routes->get('(:num)/edit', 'UsersController::edit/$1');
    $routes->post('(:num)/edit', 'UsersController::update/$1');
    $routes->post('(:num)/delete', 'UsersController::delete/$1');

    $routes->post('(:num)/edit-password', 'UsersController::update_pass/$1');
});

// routes Admin Cabang 
$routes->group('/admin', function ($routes) {
    $routes->get('/', 'AdminCabangController::index');
    $routes->post('/', 'AdminCabangController::save');

    $routes->get('(:num)/edit', 'AdminCabangController::edit/$1');
    $routes->post('(:num)/edit', 'AdminCabangController::update/$1');
    $routes->post('(:num)/delete', 'AdminCabangController::delete/$1');

    $routes->post('(:num)/edit-password', 'AdminCabangController::update_pass/$1');
});

// routes Mekanik 
$routes->group('/mekanik', function ($routes) {
    $routes->get('/', 'MekanikController::index');
    $routes->post('/', 'MekanikController::save', ['filter' => ['selectCabang']]);

    $routes->get('(:num)/edit', 'MekanikController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'MekanikController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'MekanikController::delete/$1');
});

// routes Status 
$routes->group('/status', function ($routes) {
    $routes->get('/', 'StatusController::index');
    $routes->post('/', 'StatusController::save', ['filter' => ['selectCabang']]);

    $routes->post('order-data', 'StatusController::orderData', ['filter' => ['selectCabang']]);

    $routes->get('(:num)/edit', 'StatusController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'StatusController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'StatusController::delete/$1');
});

// routes Biaya 
$routes->group('/biaya', function ($routes) {
    $routes->get('/', 'SettingBiayaController::index');
    $routes->post('/', 'SettingBiayaController::save', ['filter' => ['selectCabang']]);

    $routes->get('(:num)/edit', 'SettingBiayaController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'SettingBiayaController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'SettingBiayaController::delete/$1');
});

// routes Material 
$routes->group('/material', function ($routes) {
    $routes->get('/', 'MaterialController::index');
    $routes->post('/', 'MaterialController::save', ['filter' => ['selectCabang']]);

    $routes->get('(:num)/edit', 'MaterialController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'MaterialController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'MaterialController::delete/$1');
});

// routes Material Masuk
$routes->group('/material-masuk', function ($routes) {
    $routes->get('/', 'MaterialMasukController::index');

    $routes->get('add', 'MaterialMasukController::add');
    $routes->post('add', 'MaterialMasukController::save', ['filter' => ['selectCabang']]);

    $routes->get('item/(:num)', 'MaterialMasukController::item/$1');
    $routes->post('(:num)/add-item', 'MaterialMasukController::itemAdd/$1');
    $routes->post('del-item', 'MaterialMasukController::itemDelete');
    $routes->post('item-temp-save', 'MaterialMasukController::itemTempSave');
    $routes->post('sync-data-item', 'MaterialMasukController::itemSyncData');
    $routes->post('cancel-sync-data-item', 'MaterialMasukController::itemCancelSyncData');
    $routes->post('render-item', 'ServerSideController::itemMaterialMasuk');
    $routes->post('items', 'ServerSideController::itemsMaterialMasuk');


    $routes->get('(:num)/edit', 'MaterialMasukController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'MaterialMasukController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'MaterialMasukController::delete/$1');
});

$routes->group('/material-keluar', function ($routes) {
    $routes->get('/', 'MaterialKeluarController::index');
    $routes->post('(:num)/add', 'MaterialkeluarController::save/$1');
    $routes->get('(:num)/detail', 'MaterialkeluarController::fetchMaterialUnit/$1');

    $routes->get('(:num)/delete', 'MaterialkeluarController::delete/$1');
});

// route unit
$routes->group('/unit', function ($routes) {
    $routes->get('/', 'UnitController::index');
    $routes->get('add', 'UnitController::add');
    $routes->post('add', 'UnitController::save', ['filter' => ['selectCabang']]);

    $routes->get('(:num)/edit', 'UnitController::edit/$1', ['filter' => ['selectCabang']]);
    $routes->post('(:num)/edit', 'UnitController::update/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/update-status', 'UnitController::updateStatus/$1');
    $routes->post('(:num)/status-update', 'UnitController::statusUpdate/$1');
    $routes->get('(:num)/detail', 'UnitController::detail/$1');

    $routes->post('(:num)/add-material', 'UnitController::saveMaterial/$1', ['filter' => ['selectCabang']]);

    $routes->post('(:num)/delete', 'UnitController::delete/$1');
});

// route laporan
$routes->group('/laporan', function ($routes) {
    $routes->get('closing-mekanik', 'LaporanController::closingMekanik');
    $routes->get('closingan', 'LaporanController::closingan');

    $routes->post('closing-mekanik', 'LaporanController::sideDataClosingMekanik');
    $routes->post('closingan', 'LaporanController::sideDataClosingan');
});

$routes->group('/cetak', function ($routes) {
    
    $routes->get('epoxy', 'CetakController::epoxy');
    $routes->get('epoxy/add', 'CetakController::addEpoxy');
    $routes->post('epoxy/add', 'CetakController::saveEpoxy', ['filter' => ['selectCabang']]);
    $routes->get('epoxy/(:num)/detail', 'CetakController::detailEpoxy/$1');
    
    $routes->get('gandeng', 'CetakController::gandeng');
    $routes->get('gandeng/add', 'CetakController::addGandeng');
    $routes->post('gandeng/add', 'CetakController::saveGandeng', ['filter' => ['selectCabang']]);
    $routes->get('gandeng/(:num)/detail', 'CetakController::detailGandeng/$1');
    
    $routes->get('pemakaian-bahan', 'CetakController::pemakaianBahan');
    
    $routes->post('uploadfoto', 'CetakController::uploadFoto');
    $routes->post('(:num)/delete', 'CetakController::delete/$1', ['filter' => ['selectCabang']]);
});
