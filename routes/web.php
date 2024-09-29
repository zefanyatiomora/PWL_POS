<?php
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    // menampilkan halaman awal user
    Route::get('/', [UserController::class, 'index']);
    // menampilkan data user dalam bentuk json untuk datatables
    Route::post('/list', [UserController::class, 'list']);
    // menampilkan halaman form tambah user
    Route::get('/create', [UserController::class, 'create']);
    // menyimpan data user baru
    Route::post('/', [UserController::class, 'store']);
    // menampilkan detail user
    Route::get('/{id}', [UserController::class, 'show']);
    // menampilkan halaman form edit user
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    // menyimpan perubahan data user
    Route::put('/{id}', [UserController::class, 'update']);
    // menghapus data user
    Route::delete('/{id}', [UserController::class, 'destroy']);
});