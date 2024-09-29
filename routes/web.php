<?php
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Level
Route::get('/level', [LevelController::class, 'index']);

// Route untuk Kategori
Route::get('/kategori', [KategoriController::class, 'index']);

// Route untuk User
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']); // Perbaikan di sini
Route::delete('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/', [WelcomeController::class, 'index']);
