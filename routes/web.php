<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\PmikController;
use App\Http\Controllers\AdminController;



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'nocache', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/user/{id}/role', [AdminController::class, 'updateRole'])->name('admin.user.role');
    Route::get('/user/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::post('/user/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.user.reset');
});


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->middleware('nocache');

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index'])
    ->middleware('nocache')
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('reset.password');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Lupa Password via Email
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('forgot.send');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password/process', [LoginController::class, 'processReset'])->name('password.process');
/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE
|--------------------------------------------------------------------------
*/
// Dashboard PMIK
Route::get('/dashboard-pmik', [DashboardController::class, 'index'])
    ->middleware(['auth', 'nocache', 'role:pmik'])
    ->name('dashboard.pmik');

// Dashboard Apoteker
Route::get('/dashboard-apoteker', [ApotekerController::class, 'index'])
    ->middleware(['auth', 'nocache', 'role:apoteker'])
    ->name('dashboard.apoteker');


/*
|--------------------------------------------------------------------------
| PMIK - DATA PASIEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pmik,admin'])->group(function () {
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/detail/{id}', [PasienController::class, 'detail'])->name('pasien.detail');
    Route::get('/pasien/edit/{id}', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::post('/pasien/update/{id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::get('/pasien/delete/{id}', [PasienController::class, 'destroy'])->name('pasien.delete');
});

/*
|--------------------------------------------------------------------------
| DOKTER - DASHBOARD, PASIEN & RESEP
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'nocache', 'role:dokter,admin'])->group(function () {
    // Tampilan halaman profil
    Route::get('/dokter/profile', [DokterController::class, 'profile'])->name('dokter.profile');
    
    // Proses update profil
    Route::put('/dokter/profile/update', [DokterController::class, 'updateProfile'])->name('dokter.profile.update');
    
    // Dashboard Dokter
    Route::get('/dashboard-dokter', [DokterController::class, 'index'])->name('dashboard.dokter');
    
    // Data Pasien Khusus Dokter (Untuk Lihat & Tambah Resep)
    Route::get('/dokter/pasien', [DokterController::class, 'dataPasien'])->name('dokter.pasien');
    Route::get('/dokter/pasien/{id}', [DokterController::class, 'showPasien'])->name('dokter.pasien.show');
    
    // CRUD Resep (Perhatikan penambahan ->name() di sini)
    Route::get('/resep', [ResepController::class, 'index'])->name('resep.index');
    Route::get('/resep/create', [ResepController::class, 'create'])->name('resep.create');
    Route::post('/resep/store', [ResepController::class, 'store'])->name('resep.store');
    Route::get('/resep/edit/{id}', [ResepController::class, 'edit'])->name('resep.edit');
    Route::post('/resep/update/{id}', [ResepController::class, 'update'])->name('resep.update');
    Route::get('/resep/delete/{id}', [ResepController::class, 'destroy'])->name('resep.delete');
});

/*
|--------------------------------------------------------------------------
| APOTEKER - RESEP & UPDATE STATUS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:apoteker,admin'])->group(function () {
    // Menampilkan semua data resep
    Route::get('/apoteker/resep', [ApotekerController::class, 'dataResep'])->name('apoteker.resep.index');
    Route::get('/apoteker/obat', [ApotekerController::class, 'stokObat'])->name('apoteker.obat.index');
    Route::get('/apoteker/resep/cetak/{id}', [ApotekerController::class, 'cetakPDF'])->name('apoteker.resep.cetak');
    Route::get('/apoteker/resep/{id}/detail', [ApotekerController::class, 'detailResep'])->name('apoteker.resep.detail');
    Route::get('/apoteker/notifikasi', [ApotekerController::class, 'notifikasi'])->name('apoteker.notifikasi');

    // Route untuk mengupdate status resep oleh Apoteker
    Route::post('/apoteker/resep/{id}/penebusan', [ApotekerController::class, 'updatePenebusan'])->name('apoteker.resep.penebusan');
    Route::post('/apoteker/resep/{id}/pilih-obat', [ApotekerController::class, 'updateObatDipilih'])->name('apoteker.resep.pilihobat');
    Route::post('/resep/update-status/{id}', [ApotekerController::class, 'updateStatus'])->name('resep.updateStatus');
    Route::post('/apoteker/stok/store', [ApotekerController::class, 'storeObat'])->name('apoteker.stok.store');
    // Route untuk mengupdate stok obat
    Route::put('/apoteker/stok/update/{id}', [ApotekerController::class, 'updateObat'])->name('apoteker.stok.update');
});

/*
|--------------------------------------------------------------------------
| PENGATURAN PROFIL (Semua Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});