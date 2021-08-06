<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/user/list', [UserController::class, 'userListView'])->name('user.list')->middleware(['auth','UserIsAdmin']);
Route::post('/user/list', [UserController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/user/add', [UserController::class, 'addUserView'])->name('user.add')->middleware(['auth','UserIsAdmin']);
Route::post('/user/add', [UserController::class, 'addUser'])->middleware(['auth','UserIsAdmin']);


Route::get('/event/list', [UserController::class, 'userListView'])->name('event.list')->middleware(['auth','UserIsAdmin']);
Route::post('/event/list', [UserController::class, ''])->middleware(['auth','UserIsAdmin']);
Route::get('/event/add', [UserController::class, 'addUserView'])->name('event.add')->middleware(['auth','UserIsAdmin']);
Route::post('/event/add', [UserController::class, 'addUser'])->middleware(['auth','UserIsAdmin']);

// Route::get('/certificate/list', [UserController::class, 'userListView'])->name('certificate.list')->middleware(['auth','UserIsAdmin']);
// Route::get('/certificate/user/{username}', [UserController::class, ''])->name('certificate.user')->middleware(['auth']);
// Route::get('/certificate/user/{username}/{certificateID}', [UserController::class, ''])->name('certificate.user.id')->middleware(['auth']);
