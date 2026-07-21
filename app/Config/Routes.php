<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// Owner
$routes->get('/owner', 'Owner\OwnerControl::index');
$routes->get('/owner/dashboard', 'Owner\DashboardControl::index');
$routes->get('owner/logout', 'Auth\Auth::logout');

$routes->get('/owner/users', 'Owner\UsersControl::index');
$routes->post('/owner/users/save', 'Owner\UsersControl::save');
$routes->get('/owner/users/get/(:num)', 'Owner\UsersControl::get/$1');
$routes->post('/owner/users/hapus/(:num)', 'Owner\UsersControl::hapus/$1');

$routes->get('/owner/kategori', 'Owner\KategoriControl::index');
$routes->post('/owner/kategori/save', 'Owner\KategoriControl::save');
$routes->get('/owner/kategori/get/(:num)', 'Owner\KategoriControl::get/$1');
$routes->post('/owner/kategori/hapus/(:num)', 'Owner\KategoriControl::hapus/$1');

$routes->get('/owner/produk', 'Owner\ProdukControl::index');
$routes->post('/owner/produk/save', 'Owner\ProdukControl::save');
$routes->post('/owner/produk/store', 'Owner\ProdukControl::store');
$routes->get('/owner/produk/get/(:num)', 'Owner\ProdukControl::get/$1');
$routes->post('/owner/produk/update/(:num)', 'Owner\ProdukControl::update/$1');
$routes->post('/owner/produk/hapus/(:num)', 'Owner\ProdukControl::hapus/$1');

$routes->get('/owner/satuan', 'Owner\SatuanControl::index');
$routes->post('/owner/satuan/save', 'Owner\SatuanControl::save');
$routes->get('/owner/satuan/get/(:num)', 'Owner\SatuanControl::get/$1');
$routes->post('/owner/satuan/hapus/(:num)', 'Owner\SatuanControl::hapus/$1');

$routes->get('/owner/penjualan', 'Owner\PenjualanControl::index');
$routes->post('/owner/penjualan/save', 'Owner\PenjualanControl::save');
$routes->get('/owner/penjualan/get/(:num)', 'Owner\PenjualanControl::get/$1');
$routes->post('/owner/penjualan/hapus/(:num)', 'Owner\PenjualanControl::hapus/$1');

$routes->get('/owner/inventory', 'Owner\InventoryControl::index');
$routes->post('/owner/inventory/save', 'Owner\InventoryControl::save');

$routes->get('/owner/pembelian', 'Owner\PembelianControl::index');
$routes->post('/owner/pembelian/save', 'Owner\PembelianControl::save');

$routes->get('/owner/penjualan', 'Owner\PenjualanControl::index');


$routes->get('/detailbeli/(:num)', 'Owner\PembelianControl::detail/$1');
$routes->post('/detailbeli/savedetail', 'Owner\PembelianControl::savedetail');
$routes->get('/detailbeli/get/(:num)', 'Owner\PembelianControl::get/$1');
$routes->post('/detailbeli/hapusdetail/(:num)', 'Owner\PembelianControl::hapusdetail/$1');

$routes->get('/detailjual/(:num)', 'Owner\PenjualanControl::detail/$1');
$routes->post('/detailjual/savedetail', 'Owner\PenjualanControl::savedetail');
$routes->get('/detailjual/get/(:num)', 'Owner\PenjualanControl::get/$1');
$routes->post('/detailjual/hapusdetail/(:num)', 'Owner\PenjualanControl::hapusdetail/$1');

$routes->post('/owner/pembelian/hapus/(:num)', 'Owner\PembelianControl::hapus/$1');


// Kasir
$routes->get('/kasir', 'Kasir\KasirControl::index');
$routes->get('/kasir/cek', 'Kasir\KasirControl::cek');
$routes->post('/kasir/checkout', 'Kasir\KasirControl::checkout');
$routes->post('/kasir/add', 'Kasir\KasirControl::add');
$routes->get('/kasir/clear', 'Kasir\KasirControl::clear');
$routes->post('/kasir/update', 'Kasir\KasirControl::update');
$routes->get('/kasir/delete/(:any)', 'Kasir\KasirControl::delete/$1');


// Bagian Login
$routes->get('/', 'Auth\Auth::index');
$routes->get('login', 'Auth\Auth::index');
$routes->post('loginProcess', 'Auth\Auth::loginProcess');
$routes->get('logout', 'Auth\Auth::logout');

// Grouping Owner - Cukup tulis 'auth' saja
$routes->group('owner', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Owner\OwnerControl::index');
});

// Grouping Kasir - Cukup tulis 'auth' saja
$routes->group('kasir', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Kasir\KasirControl::index'); // Mengarah ke Controllers\Kasir fungsi index
});



//laporan harian
$routes->get('/owner/laporan/laporanharian', 'Owner\LaporanControl::index');
$routes->post('/owner/laporan/viewlaporanharian', 'Owner\LaporanControl::ViewLaporanHarian');
$routes->get('/owner/print-Harian', 'Owner\LaporanControl::printLaporanHarian');


//laporan bulanan
$routes->get('/owner/laporan/laporanbulanan', 'Owner\LaporanControl::bulan');
$routes->post('/owner/laporan/viewlaporanbulanan', 'Owner\LaporanControl::ViewLaporanBulanan');
$routes->get('/owner/print-Bulanan', 'Owner\LaporanControl::printLaporanBulanan');

//laporan tahunan
$routes->get('/owner/laporan/laporantahunan', 'Owner\LaporanControl::tahun');
$routes->post('/owner/laporan/viewlaporantahunan', 'Owner\LaporanControl::ViewLaporanTahunan');
$routes->get('/owner/print-Tahunan', 'Owner\LaporanControl::printLaporanTahunan');

//laporan stok
$routes->get('/owner/laporan/laporanstok', 'Owner\LaporanControl::stok');
$routes->post('/owner/laporan/viewlaporanstok', 'Owner\LaporanControl::ViewLaporanStok');
$routes->get('/owner/print-Stok', 'Owner\LaporanControl::printLaporanStok');
