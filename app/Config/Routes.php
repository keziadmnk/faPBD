<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingPageController::index');
$routes->get('login', 'LoginController::index');
$routes->get('daftar', 'DaftarController::index');
$routes->post('login/submit', 'LoginController::submit');
$routes->get('/dashboard', 'DashboardController::index'); // Halaman dashboard setelah login isinya pilih institusi
$routes->get('/dashboard/tryout/(:num)', 'DashboardController::tryout/$1');  // Mengakses tryout berdasarkan kategori

$routes->get('/dashboard/complete_tryout/(:num)', 'DashboardController::completeTryout/$1');
$routes->post('/dashboard/buy_tryout/(:num)', 'DashboardController::buyTryout/$1');

$routes->get('/dashboard/help', 'DashboardController::help');
$routes->get('/dashboard/topuphistory', 'DashboardController::topuphistory');
$routes->get('/dashboard/voucherhistory', 'DashboardController::voucherhistory');
$routes->get('/dashboard/tryouthistory', 'DashboardController::tryouthistory');


$routes->get('/dashboard/account', 'DashboardController::account');
$routes->get('/dashboard/security', 'DashboardController::security');

$routes->get('/dashboard/user/tryout', 'DashboardController::userTryout');
$routes->get('/dashboard/user/tryout/(:num)', 'DashboardController::attention/$1');
// $routes->get('/dashboard/start_tryout/(:num)', 'DashboardController::startTryout/$1');
$routes->get('/dashboard/start_tryout/(:num)', 'StartTryoutController::index/$1');

$routes->post('/dashboard/save_answers', 'StartTryoutController::saveAnswers');
$routes->get('/dashboard/get_answers/(:num)/(:num)', 'StartTryoutController::getExistingAnswers/$1/$2');
$routes->get('/dashboard/user/tryout/finish/(:num)', 'StartTryoutController::finish/$1');
// Route untuk menampilkan hasil tryout
$routes->get('/dashboard/user/tryout/(:num)/results', 'StartTryoutController::showResults/$1');


// $routes->get('/dashboard/tryout_purchase/(:any)', 'DashboardController::tryoutPurchase/$1');




