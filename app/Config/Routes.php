<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Halaman Welcome / Landing Page
$routes->get('/', 'Home::index');

// Rute untuk Karyawan (Front-end Ticketing)
$routes->get('/tiket/buat', 'TicketController::create'); 
$routes->post('/tiket/store', 'TicketController::store'); 
$routes->get('/tiket/lacak', 'TicketController::lacak');
$routes->post('/tiket/konfirmasi/(:num)', 'TicketController::konfirmasiSelesai/$1');


// Rute Autentikasi (Login Admin)
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::process');
$routes->get('/logout', 'AuthController::logout');

// --- Rute Khusus Kelola departemen ---
$routes->get('/admin/departemen', 'DepartemenController::index');
$routes->post('/admin/departemen/store', 'DepartemenController::store');
$routes->post('/admin/departemen/delete/(:num)', 'DepartemenController::delete/$1');
$routes->post('/admin/departemen/update/(:num)', 'DepartemenController::update/$1');

// Rute Admin 
$routes->group('admin', static function ($routes) {
$routes->get('/', 'AdminController::index');
$routes->get('users', 'AdminController::users');
$routes->get('users/create', 'AdminController::createUser');
$routes->get('users/create-teknisi', 'AdminController::createTeknisi');
$routes->post('users/store-teknisi', 'AdminController::storeTeknisi');
$routes->post('users/store', 'AdminController::storeUser');
$routes->get('tickets', 'AdminController::tickets');
$routes->get('tickets/show/(:num)', 'AdminController::showTicket/$1');
$routes->post('tickets/update-status/(:num)', 'AdminController::updateTicketStatus/$1');
$routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
$routes->post('users/update/(:num)', 'AdminController::updateUser/$1');
$routes->get('users/delete/(:num)', 'AdminController::deleteUser/$1');
$routes->get('/admin/tickets/get-new-count', 'AdminController::getNewTicketCount');

// --- Rute Khusus Kelola Teknisi ---
$routes->get('teknisi', 'AdminController::teknisi');               // Halaman Tabel Data
$routes->get('teknisi/create', 'AdminController::createTeknisi');  // Halaman Form
$routes->post('teknisi/store', 'AdminController::storeTeknisi');   // Proses Simpan
$routes->post('teknisi/update/(:any)', 'AdminController::teknisiUpdate/$1');
$routes->get('teknisi/delete/(:any)', 'AdminController::deleteTeknisi/$1');
// Rute Laporan
$routes->get('reports', 'AdminController::reports');


   
});