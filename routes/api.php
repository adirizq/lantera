<?php

use App\Models\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\ScoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/validate-token', function (Request $request) {
    $credentials  = $request->validate([
        'token' => 'required',
    ]);

    $token = DB::table('personal_access_tokens')->where('token', hash('sha256', request('token')))->first();

    if (isset($token)) {
        return ['status' => 'valid'];
    } else {
        return ['status' => 'invalid'];
    }
});

Route::controller(UserController::class)->group(function () {
    Route::post('kader-login', 'apiKaderLogin');
    Route::get('kader-user/{hashToken}', 'apiShow');
    Route::get('kader-data/{hashToken}', 'apiShowKader');
});

Route::controller(KaderController::class)->group(function () {
    Route::get('kader', 'apiIndex');
    Route::get('kader/{kader}', 'apiShow');
    Route::post('kader', 'apiRegister');
});

Route::controller(PuskesmasController::class)->group(function () {
    Route::get('puskesmas', 'apiIndex');
    Route::get('puskesmas/{puskesmas}', 'apiShow');
});

Route::controller(PosyanduController::class)->group(function () {
    Route::get('posyandu/{puskesmas}', 'apiIndex');
    Route::get('posyandu/{posyandu}', 'apiShow');
});

Route::controller(LansiaController::class)->group(function () {
    Route::get('lansia/puskesmas/{puskesmas}', 'apiIndex');
    Route::get('lansia/{lansia}', 'apiShow');
    Route::post('lansia', 'apiRegister');
    Route::delete('lansia/{lansia}', 'apiDestroy');
});

Route::controller(PemeriksaanController::class)->group(function () {
    Route::get('pemeriksaan', 'apiIndex');
    Route::get('pemeriksaan/{pemeriksaan}', 'apiShow');
    Route::post('pemeriksaan', 'apiRegister');
    Route::delete('pemeriksaan/{pemeriksaan}', 'apiDestroy');
    Route::get('pemeriksaan-by-lansia/{lansia}', 'apiByLansia');
    Route::get('pemeriksaan-by-kader/{kader}', 'apiByKader');
});

Route::controller(ScoreController::class)->group(function () {
    Route::get('score-pemeriksaan/{score}', 'apiShow');
});
