<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InfraTypeController;
use App\Http\Controllers\InfrastructureController;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\Route;

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




Auth::routes();
// Route::get('/logout', [Auth\LoginController::class, 'logout']);
// Route::get('/', [DashboardController::class, 'index']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// user
Route::get('user/list', [UserController::class, 'data'])->name('user.list');
Route::get('infra_type/list', [InfraTypeController::class, 'data'])->name('infra_type.list');
Route::get('infra_data/list', [InfrastructureController::class, 'data'])->name('infra_data.list');

Route::resource('user', UserController::class);

Route::resource('infra_type', InfraTypeController::class);

Route::get('/infra_data/export_garansi', [InfrastructureController::class, 'export_excel'])->name('infra_data.export_garansi');
Route::get('/infra_data/index_report', [InfrastructureController::class, 'indexReport'])->name('infra_data.index_report');
Route::get('/infra_data/export_report', [InfrastructureController::class, 'export_report'])->name('infra_data.export_report');

Route::resource('infra_data', InfrastructureController::class);

