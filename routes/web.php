<?php

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

// Installation
Route::prefix('install')->as('install.')->group(function () {
    Route::get('/', [InstallationController::class, 'installView'])->name('view');
    Route::get('/config', [InstallationController::class, 'installConfigView'])->name('config');
    Route::post('/config', [InstallationController::class, 'install']);
    Route::get('/success', [InstallationController::class, 'installSuccessView'])->name('success');
});

Route::get('/', [HomeController::class, 'view'])->name('home')->middleware(['auth']);
Route::get('/signature', [HomeController::class, 'signatureView'])->name('signature')->middleware(['auth']); // Generate signature PNG for certs

Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::prefix('user')->as('user.')->middleware(['auth'])->group(function () {
    Route::get('/list', [UserController::class, 'userListView'])->name('list')->middleware(['UserIsAdmin']);
    Route::post('/list', [UserController::class, ''])->middleware(['UserIsAdmin']);
    Route::get('/add', [UserController::class, 'addUserView'])->name('add')->middleware(['UserIsAdmin']);
    Route::post('/add', [UserController::class, 'addUser'])->middleware(['UserIsAdmin']);
    Route::post('/remove', [UserController::class, 'removeUser'])->name('remove')->middleware(['UserIsAdmin']);
    Route::get('/update/{username}', [UserController::class, 'updateUserView'])->name('update');
    Route::post('/update/{username}', [UserController::class, 'updateUser'])->name('update');
});

Route::prefix('event')->as('event.')->middleware(['auth'])->group(function () {
    Route::get('/list', [EventController::class, 'eventListView'])->name('list')->middleware(['UserIsAdmin']);
    Route::post('/list', [EventController::class, ''])->middleware(['UserIsAdmin']);
    Route::get('/add', [EventController::class, 'addEventView'])->name('add')->middleware(['UserIsAdmin']);
    Route::post('/add', [EventController::class, 'addEvent'])->middleware(['UserIsAdmin']);
    Route::post('/remove', [EventController::class, 'removeEvent'])->name('remove')->middleware(['UserIsAdmin']);
    Route::get('/update/{id}', [EventController::class, 'updateEventView'])->name('update')->middleware(['auth']);
    Route::post('/update/{id}', [EventController::class, 'updateEvent'])->middleware(['UserIsAdmin']);
    // Event certificate layout
    Route::get('/layout/{id}', [EventController::class, 'layoutView'])->name('layout')->middleware(['UserIsAdmin']);
    Route::post('/layout/{id}', [EventController::class, 'layoutSave'])->name('layout')->middleware(['UserIsAdmin']);
    //Remove all event certificates
    Route::post('/update/remove-certificate/{id}', [EventController::class, 'removeEventCertificate'])->name('remove.certificate')->middleware(['UserIsAdmin']);
});

Route::prefix('certificate')->as('certificate.')->group(function () {
    Route::get('/list', [CertificateController::class, 'certificateListView'])->name('list')->middleware(['auth']);
    Route::get('/view/{uid}', [CertificateController::class, 'certificateView'])->name('view');
    Route::get('/add', [CertificateController::class, 'addCertificateView'])->name('add')->middleware(['auth', 'UserIsAdmin']);
    Route::post('/add', [CertificateController::class, 'addCertificate'])->middleware(['auth', 'UserIsAdmin']);
    Route::post('/remove', [CertificateController::class, 'removeCertificate'])->name('remove')->middleware(['auth', 'UserIsAdmin']);
    Route::get('/update/{uid}', [CertificateController::class, 'updateCertificateView'])->name('update')->middleware(['auth', 'UserIsAdmin']);
    Route::post('/update/{uid}', [CertificateController::class, 'updateCertificate'])->middleware(['auth', 'UserIsAdmin']);
    // Download Certificate Collection
    Route::get('/collection', [CertificateController::class, 'downloadCertificateCollection'])->name('collection')->middleware(['auth']);
});

// Bulk add route
Route::post('/user/addBulk', [UserController::class, 'addUserBulk'])->name('user.add.bulk')->middleware(['auth', 'UserIsAdmin']);
Route::post('/certificate/addBulk', [CertificateController::class, 'addCertificateBulk'])->name('certificate.add.bulk')->middleware(['auth', 'UserIsAdmin']);

// Statistic route
Route::get('/statistic', [HomeController::class, 'statisticView'])->name('statistic')->middleware(['auth', 'UserIsAdmin']);

// Authenticity check  page
Route::get('/certificate/authenticity/{uid}', [CertificateController::class, 'authenticity'])->name('authenticity');

// System settings route
Route::prefix('system')->group(function () {
    Route::get('/', [SystemController::class, 'systemView'])->name('system')->middleware(['auth', 'UserIsAdmin']);
    Route::post('/', [SystemController::class, 'systemUpdate'])->middleware(['auth', 'UserIsAdmin']);
});
