<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiLokasiController;
use App\Http\Controllers\ApiPresensiController;
use App\Http\Controllers\ApiIzinController;
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

Route::get('/Users/login/{nip}/{password}/{serialdevice}', [ApiUserController::class, 'loginUser']);
Route::get('/Users/getUser/{nip}', [ApiUserController::class, 'getUserByID']);
Route::any('/Users/updateUser', [ApiUserController::class, 'updateUser']);
Route::any('/Users/changeFoto', [ApiUserController::class, 'changeFoto']);
Route::get('/Lokasi/get', [ApiLokasiController::class, 'getLokasi']);
Route::post('/Presensi/insertPresensi', [ApiPresensiController::class, 'insertPresensi']);
Route::any('/Presensi/getHistory/{nip}/{tanggal}', [ApiPresensiController::class, 'getHistory']);
Route::get('/Presensi/getJamAbsen', [ApiPresensiController::class, 'getJamPresensi']);
Route::any('/Izin/insertIzin', [ApiIzinController::class, 'insertIzin']);
Route::any('/Izin/getHistory/{nip}', [ApiIzinController::class, 'getHistoryIzin']);