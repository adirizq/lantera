<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\PemeriksaanController;

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

Route::get('/', function () {
    return redirect(route('login'));
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('puskesmas', [PuskesmasController::class, 'index'])->name('usersPuskesmas');
    Route::get('puskesmas/{puskesmas}', [PuskesmasController::class, 'show'])->name('detailPuskesmas');

    Route::get('validating_puskesmas/{puskesmas}.', [PuskesmasController::class, 'validating'])->name('validatingPuskesmas');

    Route::get('remove_validation_puskesmas/{puskesmas}', [PuskesmasController::class, 'removeValidation'])->name('removeValidationPuskesmas');
});

Route::middleware(['auth', 'puskesmas'])->group(function () {
    Route::get('validating_kader/{kader}.', [KaderController::class, 'validating'])->name('validatingKader');
    Route::get('remove_validation_kader/{kader}', [KaderController::class, 'removeValidation'])->name('removeValidationKader');

    Route::resource('kader', KaderController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('posyandu', PosyanduController::class)->except(['create', 'edit']);

    Route::get('lansia', [LansiaController::class, 'index'])->name('lansia.index');
    Route::get('lansia/{lansia}', [LansiaController::class, 'show'])->name('lansia.show');

    Route::resource('pemeriksaan', PemeriksaanController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
});


Route::middleware(['auth', 'admin.or.puskesmas', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/getCities/{id}', [AreaController::class, 'getCities']);
Route::get('/getDistricts/{id}', [AreaController::class, 'getDistricts']);
Route::get('/getVillages/{id}', [AreaController::class, 'getVillages']);

require __DIR__ . '/auth.php';
