<?php
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Route;

Route::get('/level', [LevelController::class, 'index']);

Route::get('/test', function() {
    return 'Hey';
});


Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function() {
    Route::get('/', [UserController::class, 'index']); //Menampilkan laman awal user
    Route::post('/list', [UserController::class, 'list']); //menampilkan data user dalam bentuk json untuk datatables.
    Route::get('/create', [UserController::class, 'create']); //Membuat data baru
    Route::post('/', [UserController::class, 'store']); //Menyimpan data yang telah dibuat

    Route::get('/create_ajax', [UserController::class, 'create_ajax']); //menambah data user dengan ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); //menyimpan data yg telah dibuat dengan ajax
    
    Route::get('/{id}', [UserController::class, 'show']); //menampilkan detail data user
    Route::get('/{id}/edit', [UserController::class, 'edit']); //Edit data user tertentu
    Route::put('/{id}', [UserController::class, 'update']); //Menyimpan perubahan data user 

    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //edit data user dengan ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //menyimpan perubahan data dengan ajax

    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //Munculkan pop up konfirmasi delete dengan ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //Menghapus data user dengan ajax

    Route::delete('/{id}/delete_ajax', [UserController::class, 'destroy']); //Menghapus data user

} );

Route::group(['prefix' => 'level'], function() {
    Route::get('/', [LevelController::class, 'index']); //Menampilkan laman awal level
    Route::post('/list', [LevelController::class, 'list']); //menampilkan data level dalam bentuk json untuk datatables.
    Route::get('/create', [LevelController::class, 'create']); //Membuat data level
    Route::post('/', [LevelController::class, 'store']); //Menyimpan data yang telah dibuat

    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //Buat data level w ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); //menyimpan data level baru w ajax

    Route::get('/{id}', [LevelController::class, 'show']); //menampilkan detail data level?
    Route::get('/{id}/edit', [LevelController::class, 'edit']); //Edit data level tertentu
    Route::put('/{id}', [LevelController::class, 'update']); //Menyimpan perubahan data level 

    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //edit data level dengan ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //menyimpan perubahan data dengan ajax

    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //Munculkan pop up konfirmasi delete dengan ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //Menghapus data user dengan ajax

    Route::delete('/{id}', [LevelController::class, 'destroy']); //Menghapus data level
} );

Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']); //Menampilkan laman awal kategori
    Route::post('/list', [KategoriController::class, 'list']); //menampilkan data kategori dalam bentuk json untuk datatables.
    Route::get('/create', [KategoriController::class, 'create']); //Membuat data kategori
    Route::post('/', [KategoriController::class, 'store']); //Menyimpan data yang telah dibuat

    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //Buat data level w ajax
    Route::post('/store_ajax', [KategoriController::class, 'store_ajax']); //menyimpan data baru w ajax

    Route::get('/{id}', [KategoriController::class, 'show']); //menampilkan detail data kategori?
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); //Edit data kategori tertentu
    Route::put('/{id}', [KategoriController::class, 'update']); //Menyimpan perubahan data kategori 

    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //edit data kategori dengan ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); //menyimpan perubahan data dengan ajax


    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //Munculkan pop up konfirmasi delete dengan ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); //Menghapus data user dengan ajax

    Route::delete('/{id}', [KategoriController::class, 'destroy']); //Menghapus data kategori
} );

Route::group(['prefix' => 'supplier'], function() {
    Route::get('/', [SupplierController::class, 'index']); // 
    Route::post('/list', [SupplierController::class, 'list']); //
    Route::get('/create', [SupplierController::class, 'create']); //
    Route::post('/', [SupplierController::class, 'store']); //

    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //Buat data supplier w ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); //menyimpan data baru w ajax

    Route::get('/{id}', [SupplierController::class, 'show']); //
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); //
    Route::put('/{id}', [SupplierController::class, 'update']); // 

    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //edit data kategori dengan ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); //menyimpan perubahan data dengan ajax


    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //Munculkan pop up konfirmasi delete dengan ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); //Menghapus data user dengan ajax

    Route::delete('/{id}', [SupplierController::class, 'destroy']); //
} );

Route::group(['prefix' => 'barang'], function() {
    Route::get('/', [BarangController::class, 'index']); //Menampilkan laman awal barang
    Route::post('/list', [BarangController::class, 'list']); //menampilkan data barang dalam bentuk json untuk datatables.
    Route::get('/create', [BarangController::class, 'create']); //Membuat data barang
    Route::post('/', [BarangController::class, 'store']); //Menyimpan data yang telah dibuat

    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //menambah data barang dengan ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); //menyimpan data yg telah dibuat dengan ajax

    Route::get('/{id}', [BarangController::class, 'show']); //menampilkan detail data barang?
    Route::get('/{id}/edit', [BarangController::class, 'edit']); //Edit data barangtertentu
    Route::put('/{id}', [BarangController::class, 'update']); //Menyimpan perubahan data barang 

    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //edit data barang dengan ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); //menyimpan perubahan data dengan ajax

    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //Munculkan pop up konfirmasi delete dengan ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); //Menghapus data barang dengan ajax


    Route::delete('/{id}', [BarangController::class, 'destroy']); //Menghapus data barang
} );