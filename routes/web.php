<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini
    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);              // Menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);          // Menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);       // Menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);             // Menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);    // Menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']);          // Menyimpan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show']);           // Menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);      // Menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);         // Menyimpan perubahan data user
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);     // Menampilkan halaman form user Ajax
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);     // Menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);  // Menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
        Route::delete('/{id}', [UserController::class, 'destroy']);     // Menghapus data user
    });

    Route::group(['prefix' => 'level'], function () {
        Route::get('/', [LevelController::class, 'index']);              // Menampilkan halaman awal level
        Route::post('/list', [LevelController::class, 'list']);          // Menampilkan data level dalam bentuk json untuk datatables
        Route::get('/create', [LevelController::class, 'create']);       // Menampilkan halaman form tambah level
        Route::post('/', [LevelController::class, 'store']);             // Menyimpan data level baru
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);    // Menampilkan halaman form tambah level Ajax
        Route::post('/ajax', [LevelController::class, 'store_ajax']);          // Menyimpan data level baru Ajax
        Route::get('/{id}', [LevelController::class, 'show']);           // Menampilkan detail level
        Route::get('/{id}/edit', [LevelController::class, 'edit']);      // Menampilkan halaman form edit level
        Route::put('/{id}', [LevelController::class, 'update']);         // Menyimpan perubahan data level
        Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);     // Menampilkan halaman form level Ajax
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);     // Menampilkan halaman form edit level Ajax
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);  // Menyimpan perubahan data level Ajax
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
        Route::delete('/{id}', [LevelController::class, 'destroy']);     // Menghapus data level
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']);              // Menampilkan halaman awal kategori
        Route::post('/list', [KategoriController::class, 'list']);          // Menampilkan data kategori dalam bentuk json untuk datatables
        Route::get('/create', [KategoriController::class, 'create']);       // Menampilkan halaman form tambah kategori
        Route::post('/', [KategoriController::class, 'store']);             // Menyimpan data kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);    // Menampilkan halaman form tambah kategori Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);          // Menyimpan data kategori baru Ajax
        Route::get('/{id}', [KategoriController::class, 'show']);           // Menampilkan detail kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);      // Menampilkan halaman form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update']);         // Menyimpan perubahan data kategori
        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);     // Menampilkan halaman form kategori Ajax
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     // Menampilkan halaman form edit kategori Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);  // Menyimpan perubahan data kategori Ajax
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kategori Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data kategori Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']);     // Menghapus data kategori
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']);              // Menampilkan halaman awal supplier
        Route::post('/list', [SupplierController::class, 'list']);          // Menampilkan data supplier dalam bentuk json untuk datatables
        Route::get('/create', [SupplierController::class, 'create']);       // Menampilkan halaman form tambah supplier
        Route::post('/', [SupplierController::class, 'store']);             // Menyimpan data supplier baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);    // Menampilkan halaman form tambah supplier Ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);          // Menyimpan data supplier baru Ajax
        Route::get('/{id}', [SupplierController::class, 'show']);           // Menampilkan detail supplier
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);      // Menampilkan halaman form edit supplier
        Route::put('/{id}', [SupplierController::class, 'update']);         // Menyimpan perubahan data supplier
        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);     // Menampilkan halaman form supplier Ajax
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);     // Menampilkan halaman form edit supplier Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);  // Menyimpan perubahan data supplier Ajax
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete supplier Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data supplier Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']);     // Menghapus data supplier
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::get('/', [BarangController::class, 'index']);              // Menampilkan halaman awal barang
        Route::post('/list', [BarangController::class, 'list']);          // Menampilkan data barang dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']);       // Menampilkan halaman form tambah barang
        Route::post('/', [BarangController::class, 'store']);             // Menyimpan data barang baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);    // Menampilkan halaman form tambah barang Ajax
        Route::post('/ajax', [BarangController::class, 'store_ajax']);          // Menyimpan data barang baru Ajax
        Route::get('/{id}', [BarangController::class, 'show']);           // Menampilkan detail barang
        Route::get('/{id}/edit', [BarangController::class, 'edit']);      // Menampilkan halaman form edit barang
        Route::put('/{id}', [BarangController::class, 'update']);         // Menyimpan perubahan data barang
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);     // Menampilkan halaman form barang Ajax
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);     // Menampilkan halaman form edit barang Ajax
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);  // Menyimpan perubahan data barang Ajax
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
        Route::delete('/{id}', [BarangController::class, 'destroy']);     // Menghapus data barang
    });
});

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    Route::get('/', [WelcomeController::class, 'index']);
    // route Level
    // artinya semua route di dalam group ini harus punya role ADM (Administrator)
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']); // untuk list json datatables
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::post('/level', [LevelController::class, 'store']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // untuk tampilkan form edit
        Route::put('/level/{id}', [LevelController::class, 'update']); // untuk proses update data
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // untuk proses hapus data
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // ajax form create
        Route::post('/level_ajax', [LevelController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']); //ajax show
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // ajax form edit
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // ajax update
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // ajax delete
    });

    // route Barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); //ajax show
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
    });

    // route User
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/list', [UserController::class, 'list']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); // ajax form create
        Route::post('/user_ajax', [UserController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); //ajax show
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // ajax form edit
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']); // ajax update
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // ajax delete
    });

    // route Kategori
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); // ajax form create
        Route::post('/kategori_ajax', [KategoriController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']); //ajax show
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // ajax form edit
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // ajax update
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // ajax delete
    });

    // route Supplier
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index']);
        Route::post('/supplier/list', [SupplierController::class, 'list']);
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // ajax form create
        Route::post('/supplier_ajax', [SupplierController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']); //ajax show
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // ajax form edit
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // ajax update
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // ajax delete
    });
});
