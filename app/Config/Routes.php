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

// routes side server
$routes->group('/api', function ($routes) {
    $routes->get('cabang', 'ServerSideController::fetchCabang');
    $routes->get('satuan', 'ServerSideController::fetchSatuan');
    $routes->get('jenis', 'ServerSideController::fetchJenis');
});


// routes side server
$routes->group('/datatable-server-side', function ($routes) {
    $routes->post('cabang', 'ServerSideController::cabang');
    $routes->post('users', 'ServerSideController::users');
    $routes->post('admin-cabang', 'ServerSideController::admin');
    $routes->post('mekanik', 'ServerSideController::mekanik');
    $routes->post('jenis', 'ServerSideController::jenis');
    $routes->post('satuan', 'ServerSideController::satuan');
    $routes->post('status', 'ServerSideController::status');
    $routes->post('biaya', 'ServerSideController::biaya');
    $routes->post('material', 'ServerSideController::material');
    $routes->post('material-masuk', 'ServerSideController::materialMasuk');
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