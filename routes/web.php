<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\InstallationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Installation
 */

Route::get('/install', [InstallationController::class, 'installView'])->name('install.view');
Route::get('/install/config', [InstallationController::class, 'installConfigView'])->name('install.config');
Route::post('/install/config', [InstallationController::class, 'install']);
Route::get('/install/success', [InstallationController::class, 'installSuccessView'])->name('install.success');

Route::get('/', [HomeController::class, 'view'])->name('home')->middleware(['auth']);
Route::get('/signature', [HomeController::class, 'signatureView'])->name('signature')->middleware(['auth']); // Generate signature PNG for certs

Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::get('/user/list', [UserController::class, 'userListView'])->name('user.list')->middleware(['auth','UserIsAdmin']);
Route::post('/user/list', [UserController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/user/add', [UserController::class, 'addUserView'])->name('user.add')->middleware(['auth','UserIsAdmin']);
Route::post('/user/add', [UserController::class, 'addUser'])->middleware(['auth','UserIsAdmin']);
Route::post('/user/remove', [UserController::class, 'removeUser'])->name('user.remove')->middleware(['auth','UserIsAdmin']);
Route::get('/user/update/{username}', [UserController::class, 'updateUserView'])->name('user.update')->middleware(['auth']);
Route::post('/user/update/{username}', [UserController::class, 'updateUser'])->name('user.update')->middleware(['auth']);

Route::get('/event/list', [EventController::class, 'eventListView'])->name('event.list')->middleware(['auth','UserIsAdmin']);
Route::post('/event/list', [EventController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/event/add', [EventController::class, 'addEventView'])->name('event.add')->middleware(['auth','UserIsAdmin']);
Route::post('/event/add', [EventController::class, 'addEvent'])->middleware(['auth','UserIsAdmin']);
Route::post('/event/remove', [EventController::class, 'removeEvent'])->name('event.remove')->middleware(['auth','UserIsAdmin']);
Route::get('/event/update/{id}', [EventController::class, 'updateEventView'])->name('event.update')->middleware(['auth']);
Route::post('/event/update/{id}', [EventController::class, 'updateEvent'])->middleware(['auth','UserIsAdmin']);
// Event certificate layout
Route::get('/event/layout/{id}', [EventController::class, 'layoutView'])->name('event.layout')->middleware(['auth','UserIsAdmin']);
Route::post('/event/layout/{id}', [EventController::class, 'layoutSave'])->name('event.layout')->middleware(['auth','UserIsAdmin']);
//Remove all event certificates
Route::post('/event/update/remove-certificate/{id}', [EventController::class, 'removeEventCertificate'])->name('event.remove.certificate')->middleware(['auth','UserIsAdmin']);

Route::get('/certificate/list', [CertificateController::class, 'certificateListView'])->name('certificate.list')->middleware(['auth']);
Route::get('/certificate/view/{uid}', [CertificateController::class, 'certificateView'])->name('certificate.view');
Route::get('/certificate/add', [CertificateController::class, 'addCertificateView'])->name('certificate.add')->middleware(['auth','UserIsAdmin']);
Route::post('/certificate/add', [CertificateController::class, 'addCertificate'])->middleware(['auth','UserIsAdmin']);
Route::post('/certificate/remove', [CertificateController::class, 'removeCertificate'])->name('certificate.remove')->middleware(['auth','UserIsAdmin']);
Route::get('/certificate/update/{uid}', [CertificateController::class, 'updateCertificateView'])->name('certificate.update')->middleware(['auth','UserIsAdmin']);
Route::post('/certificate/update/{uid}', [CertificateController::class, 'updateCertificate'])->middleware(['auth','UserIsAdmin']);
// Download Certificate Collection
Route::get('/certificate/collection', [CertificateController::class, 'downloadCertificateCollection'])->name('certificate.collection')->middleware(['auth']);

// Bulk add route
Route::post('/user/addBulk', [UserController::class, 'addUserBulk'])->name('user.add.bulk')->middleware(['auth','UserIsAdmin']);
Route::post('/certificate/addBulk', [CertificateController::class, 'addCertificateBulk'])->name('certificate.add.bulk')->middleware(['auth','UserIsAdmin']);

// Statistic route
Route::get('/statistic', [HomeController::class, 'statisticView'])->name('statistic')->middleware(['auth','UserIsAdmin']);

// Authenticity check  page
Route::get('/certificate/authenticity/{uid}', [CertificateController::class, 'authenticity'])->name('authenticity');

// System settings route
Route::get('/system', [SystemController::class, 'systemView'])->name('system')->middleware(['auth','UserIsAdmin']);
Route::post('/system', [SystemController::class, 'systemUpdate'])->middleware(['auth','UserIsAdmin']);
