<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\DenahRuanganController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PeminjamanRuanganController;
use App\Http\Controllers\ManajemenPeminjamanController;
use App\Http\Controllers\ManajemenRuanganController;
use App\Http\Controllers\ExportPeminjamanController;  
use App\Http\Controllers\MonitorController;


use Illuminate\Support\Facades\DB;

Route::get('/', [MonitorController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/peminjaman/{id}', [DashboardController::class, 'detail'])
            ->name('petugas.peminjaman.detail');

        Route::get('/denah-ruangan', [DenahRuanganController::class, 'index'])
            ->name('denah');

        Route::get('/transaksi/{id}', [DashboardController::class, 'show'])
            ->name('transaksi.show');


       // ==========================
        // PEMINJAMAN RUANGAN
        // ==========================

        Route::get(
            '/peminjaman-ruangan',
            [PeminjamanRuanganController::class, 'index']
        )->name('peminjaman');
    

    });


/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        /*
        |------------------------------------------
        | DASHBOARD
        |------------------------------------------
        */
        Route::get('/dashboard', [SuperAdminController::class, 'index'])
            ->name('dashboard');

        /*
        |------------------------------------------
        | MANAJEMEN USER
        |------------------------------------------
        */
        Route::get('/manajemen-user', [SuperAdminController::class, 'manajemenuser'])
            ->name('manajemenuser');

        Route::get('/bidang-pegawai', [SuperAdminController::class, 'manajemenuser'])
            ->name('bidang-pegawai');

        Route::post('/bidang-pegawai/store', [SuperAdminController::class, 'storeBidang'])
            ->name('bidang.store');

        Route::get('/peminjaman-ruangan',[PeminjamanRuanganController::class, 'index'])
            ->name('peminjaman');

        Route::get('/create', [SuperAdminController::class, 'create'])
            ->name('create');

        Route::post('/store', [SuperAdminController::class, 'store'])
            ->name('store');

        Route::get('/edit/{id}', [SuperAdminController::class, 'edit'])
            ->name('edit');

        Route::post('/update/{id}', [SuperAdminController::class, 'update'])
            ->name('update');

        Route::get('/delete/{id}', [SuperAdminController::class, 'destroy'])
            ->name('delete');

        Route::delete('/user/{id}', 
            [SuperAdminController::class, 'userdestroy']
        )->name('superadmin.user.destroy');

        Route::delete('/bidang/{id}', 
            [SuperAdminController::class, 'destroyBidang']
        )->name('superadmin.bidang.destroy');



        /*
        |------------------------------------------
        | MANAJEMEN PEMINJAMAN
        |------------------------------------------
        */
        Route::get(
            '/manajemen-peminjaman',
            [ManajemenPeminjamanController::class, 'index']
        )->name('manajemen-peminjaman');

        Route::get(
            '/peminjaman/{id}',
            [ManajemenPeminjamanController::class, 'detail']
        )->name('peminjaman.detail');

        Route::post(
            '/peminjaman/{id}/approve',
            [ManajemenPeminjamanController::class, 'approve']
        )->name('peminjaman.approve');

        Route::post(
            '/peminjaman/{id}/reject',
            [ManajemenPeminjamanController::class, 'reject']
        )->name('peminjaman.reject');

        Route::post(
            '/peminjaman/{id}/upload-foto',
            [ManajemenPeminjamanController::class, 'uploadFoto']
        );

        Route::delete(
    '/peminjaman/{id}/hapus-foto',
    [ManajemenPeminjamanController::class, 'hapusFoto']
);



        /*
        |------------------------------------------
        | EXPORT PEMINJAMAN (PDF & EXCEL)
        |------------------------------------------
        */
        Route::get(
            '/peminjaman/export/excel',
            [ExportPeminjamanController::class, 'exportExcel']
        )->name('peminjaman.export.excel');

        Route::get(
            '/peminjaman/export/pdf',
            [ExportPeminjamanController::class, 'exportPdf']
        )->name('peminjaman.export.pdf');


        /*
        |------------------------------------------
        | MANAJEMEN RUANGAN
        |------------------------------------------
        */
        Route::get(
            '/manajemen-ruangan',
            [ManajemenRuanganController::class, 'index']
        )->name('manajemen-ruangan');

        Route::get('/dashboard', [SuperAdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/manajemen-user', [SuperAdminController::class, 'manajemenuser'])
            ->name('manajemenuser');

        Route::post('/bidang-pegawai/store',[SuperAdminController::class, 'storeBidang'])
            ->name('bidang.store');

        Route::put('/bidang-pegawai/update',[SuperAdminController::class, 'updateBidang'])
            ->name('bidang.update');

        Route::put('/user/update',[SuperAdminController::class, 'updateUser'])
        ->name('user.update');

        Route::put(
        '/manajemen-ruangan/{id}',
        [ManajemenRuanganController::class, 'update']
        )->name('manajemen-ruangan.update');

        Route::post('/manajemen-ruangan', 
            [ManajemenRuanganController::class, 'store']
        )->name('manajemen-ruangan.store');

        Route::delete(
            '/manajemen-ruangan/{id}',
            [ManajemenRuanganController::class, 'destroy']
        );


    });


/*
|--------------------------------------------------------------------------
| LANDING PAGE MONITOR
|--------------------------------------------------------------------------
*/
Route::get('/monitor', [MonitorController::class, 'index'])
    ->name('monitor.landingpage');


/*
|--------------------------------------------------------------------------
| KONTAK (SHARED)
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:petugas,superadmin'])
    ->get('/kontak', function () {
        return view('shared.kontak');
    })
    ->name('shared.kontak');

    /*
|--------------------------------------------------------------------------
| SHARED API (PETUGAS + SUPERADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:petugas,superadmin'])->group(function () {
     Route::post(
        '/peminjaman-ruangan',
        [PeminjamanRuanganController::class, 'store']
    )->name('peminjaman.store');
    

    // GET PEMINJAMAN (MODAL EDIT)
    Route::get(
        '/peminjaman-ruangan/{id}',
        [PeminjamanRuanganController::class, 'show']
    );

    // UPDATE PEMINJAMAN
    Route::put(
        '/peminjaman-ruangan/{id}',
        [PeminjamanRuanganController::class, 'update']
    );

    // BATALKAN PEMINJAMAN
    Route::put(
        '/peminjaman-ruangan/{id}/batalkan',
        [PeminjamanRuanganController::class, 'batalkan']
    );

    // GET SUB BIDANG
    Route::get(
        '/get-sub-bidang',
        [PeminjamanRuanganController::class, 'getSubBidang']
    );

});