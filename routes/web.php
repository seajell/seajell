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

Route::get('/user/create', [UserController::class, 'createUserView'])->name('user.create');
