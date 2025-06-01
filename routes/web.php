<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:mahasiswa'])->group(function () {

        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
        

        Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
        Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
        Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    });

    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    });

    Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware('auth')->name('dashboard');
});
