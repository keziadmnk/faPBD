<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingPageController::index');
$routes->get('login', 'LoginController::index');
$routes->get('daftar', 'DaftarController::index');
$routes->post('login/submit', 'LoginController::submit');
$routes->get('logout', 'LoginController::logout');
$routes->post('daftar/submit', 'DaftarController::submit');

$routes->get('/complete-registration', 'DaftarController::completeRegistration');
$routes->post('/complete-registration', 'DaftarController::saveCompleteRegistration');

$routes->get('/dashboard/user', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryout', 'DashboardController::userTryout', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryout/(:num)', 'DashboardController::attention/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryout/finish/(:num)', 'StartTryoutController::finish/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryout/(:num)/results', 'StartTryoutController::showResults/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/topuphistory', 'TopUpController::history', ['filter' => 'auth']);
$routes->get('/dashboard/start_tryout/(:num)', 'StartTryoutController::index/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/kategori/(:num)', 'DashboardController::tryout/$1', ['filter' => 'auth']);

$routes->get('/dashboard/account', 'DashboardController::account', ['filter' => 'auth']);
$routes->get('/dashboard/account/edit', 'DashboardController::editAccount', ['filter' => 'auth']);
$routes->post('/dashboard/account/edit', 'DashboardController::editAccount', ['filter' => 'auth']);
$routes->get('/dashboard/security', 'DashboardController::security', ['filter' => 'auth']);
$routes->get('/dashboard/help', 'DashboardController::help', ['filter' => 'auth']);
$routes->post('/dashboard/buy_tryout/(:num)', 'DashboardController::buyTryout/$1', ['filter' => 'auth']);
$routes->post('/dashboard/save_answers', 'StartTryoutController::saveAnswers', ['filter' => 'auth']);

$routes->get('/topup', 'TopUpController::index', ['filter' => 'auth']);
$routes->post('/topup/redeem_voucher', 'TopUpController::redeem_voucher', ['filter' => 'auth']);

$routes->get('/dashboard/user/voucherhistory', 'DashboardController::voucherhistory', ['filter' => 'auth']);
$routes->get('/dashboard/user/voucherhistory/detail/(:any)', 'DashboardController::voucherDetail/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryouthistory', 'DashboardController::tryouthistory', ['filter' => 'auth']);
$routes->get('/dashboard/user/tryouthistory/detail/(:num)', 'DashboardController::tryoutHistoryDetail/$1', ['filter' => 'auth']);
$routes->get('/dashboard/user/raport', 'DashboardController::raport', ['filter' => 'auth']);

$routes->get('/dashboard/review/(:num)/(:num)', 'StartTryoutController::reviewSubject/$1/$2', ['filter' => 'auth']);


// $routes->get('/dashboard/tryout_purchase/(:any)', 'DashboardController::tryoutPurchase/$1');




