<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
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
Route::get('/signature', [HomeController::class, 'signature'])->name('signature')->middleware(['auth']); // Generate signature PNG for certs

Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::get('/user/list', [UserController::class, 'userListView'])->name('user.list')->middleware(['auth','UserIsAdmin']);
Route::post('/user/list', [UserController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/user/add', [UserController::class, 'addUserView'])->name('user.add')->middleware(['auth','UserIsAdmin']);
Route::post('/user/add', [UserController::class, 'addUser'])->middleware(['auth','UserIsAdmin']);


Route::get('/event/list', [EventController::class, 'eventListView'])->name('event.list')->middleware(['auth','UserIsAdmin']);
Route::post('/event/list', [EventController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/event/add', [EventController::class, 'addEventView'])->name('event.add')->middleware(['auth','UserIsAdmin']);
Route::post('/event/add', [EventController::class, 'addEvent'])->middleware(['auth','UserIsAdmin']);

Route::get('/certificate/list', [CertificateController::class, 'certificateListView'])->name('certificate.list')->middleware(['auth']);
Route::get('/certificate/view/{id}', [CertificateController::class, 'certificateView'])->name('certificate.view');
Route::get('/certificate/add', [CertificateController::class, 'addCertificateView'])->name('certificate.add')->middleware(['auth','UserIsAdmin']);
Route::post('/certificate/add', [CertificateController::class, 'addCertificate'])->middleware(['auth','UserIsAdmin']);
//Route::get('/certificate/user/{username}', [CertificateController::class, ''])->name('certificate.user')->middleware(['auth']);
//Route::get('/certificate/user/{username}/{certificateID}', [CertificateController::class, ''])->name('certificate.user.id')->middleware(['auth']);