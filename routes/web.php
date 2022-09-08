<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JamAbsenController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\IzinController;
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

Route::any('/', [LoginController::class, 'index'])->name('index');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('home_admin');
        Route::any('/logout_admin', [AdminController::class, 'logout'])->name('logout_admin');
        Route::any('/profile_admin', [AdminController::class, 'profileAdmin'])->name('profile_admin');
        Route::any('/update_profile_admin', [AdminController::class, 'updateProfileAdmin'])->name('update_profileAdmin');

        Route::any('/waktu_absen', [JamAbsenController::class, 'jamAbsen'])->name('jam_absen');
        Route::any('/waktu_absen/update_waktu_absen', [JamAbsenController::class, 'updateJamAbsen'])->name('update_jamAbsen');
        
        Route::any('/lokasi_absen', [LokasiController::class, 'lokasiAbsen'])->name('lokasi_absen');
        Route::any('/lokasi_absen/update_lokasi_absen', [LokasiController::class, 'updateLokasiAbsen'])->name('update_lokasiAbsen');

        Route::any('/data_karyawan', [UserController::class, 'dataKaryawan'])->name('data_karyawan');
        Route::any('/data_karyawan/tambah', [UserController::class, 'tambahDataKaryawan'])->name('tambah_karyawan');
        Route::any('/data_karyawan/update', [UserController::class, 'updateDataKaryawan'])->name('update_karyawan');
        Route::any('/data_karyawan/delete{id}', [UserController::class, 'deleteDataKaryawan'])->name('delete_karyawan');

        Route::any('/data_jabatan', [JabatanController::class, 'dataJabatan'])->name('data_jabatan');
        Route::any('/data_jabatan/tambah', [JabatanController::class, 'tambahDataJabatan'])->name('tambah_jabatan');
        Route::any('/data_jabatan/update', [JabatanController::class, 'updateDataJabatan'])->name('update_jabatan');
        Route::any('/data_jabatan/delete{jabatan_id}', [JabatanController::class, 'deleteDataJabatan'])->name('delete_jabatan');
        
        Route::any('/data_presensi', [PresensiController::class, 'dataPresensi'])->name('data_presensi');
        Route::any('/data_presensi/delete{presensi_id}', [PresensiController::class, 'deleteDataPresensi'])->name('delete_dataPresensi');
        Route::any('/data_presensi/print', [PresensiController::class, 'printDataPresensi'])->name('print_dataPresensi');

        Route::any('/data_izin', [IzinController::class, 'dataIzin'])->name('data_izin');
        Route::any('/data_izin/delete{izin_id}', [IzinController::class, 'deleteDataIzin'])->name('delete_izin');
        Route::any('/data_izin/setujui{izin_id}', [IzinController::class, 'accDataIzin'])->name('acc_izin');
        Route::any('/data_izin/tolak', [IzinController::class, 'tolakDataIzin'])->name('tolak_izin');
        Route::any('/data_izin/print', [IzinController::class, 'printDataIzin'])->name('print_izin');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('karyawan')->middleware(['karyawan'])->group(function () {
        Route::any('/home', [KaryawanController::class, 'index'])->name('home_karyawan');
        Route::any('/logout_karyawan', [KaryawanController::class, 'logout'])->name('logout_karyawan');
        Route::any('/presensi', [KaryawanController::class, 'historyPresensiKaryawan'])->name('presensi_karyawan');
        Route::any('/profile', [KaryawanController::class, 'profileKaryawan'])->name('profile_karyawan');
        Route::any('/update_profile', [KaryawanController::class, 'updateProfileKaryawan'])->name('update_profile');
    });
});