<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;

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
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('profile', [AuthController::class, 'profile'])->middleware('auth')->name('profile');
Route::post('profile/update', [AuthController::class, 'update'])->middleware('auth');

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
        Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
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
        Route::get('/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
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
        Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
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
        Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); //ajax show
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
        Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [BarangController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'stok'], function () {
        Route::get('/', [StokController::class, 'index']);
        Route::post('/list', [StokController::class, 'list']);
        Route::get('/create_ajax', [StokController::class, 'create_ajax']); // ajax form create
        Route::post('/ajax', [StokController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']); //ajax show
        Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // ajax form edit
        Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // ajax update
        Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // ajax delete
        Route::get('/import', [StokController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [StokController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [StokController::class, 'export_excel']); // export excel
    });

    Route::group(['prefix' => 'penjualan'], function () {
        Route::get('/', [PenjualanController::class, 'index']);
        Route::post('/list', [PenjualanController::class, 'list']);
        Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']); // ajax form create
        Route::post('/ajax', [PenjualanController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']); //ajax show
        Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // ajax form edit
        Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // ajax update
        Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // ajax delete
        Route::get('/import', [PenjualanController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [PenjualanController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [PenjualanController::class, 'export_excel']); // export excel
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
        Route::get('/level/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']); // export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
    });

    // route Barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); //ajax show
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // export excel
        Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
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
        Route::get('/user/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
        Route::get('/user/export_excel', [UserController::class, 'export_excel']); // export excel
        Route::get('/user/export_pdf', [UserController::class, 'export_pdf']); // export pdf
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
        Route::get('/kategori/import', [KategoriController::class, 'import']); // ajax form upload excel
        Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
        Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); // export excel
        Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); // export excel
        Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']); // export pdf
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
        Route::get('/supplier/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
        Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); // export excel
        Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']); // export pdf
    });

    // route Stok
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/stok', [StokController::class, 'index']);
        Route::post('/stok/list', [StokController::class, 'list']);
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); // ajax form create
        Route::post('/stok_ajax', [StokController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']); //ajax show
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // ajax form edit
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']); // ajax update
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // ajax delete
        Route::get('/stok/import', [StokController::class, 'import']); // ajax form upload excel
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); // ajax import excel
        Route::get('/stok/export_excel', [StokController::class, 'export_excel']); // export excel
        Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); // export pdf
    });

    // route penjualan
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']); // ajax form create
        Route::post('/penjualan_ajax', [PenjualanController::class, 'store_ajax']); // ajax store
        Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']); //ajax show
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // ajax form edit
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // ajax update
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // ajax delete
        Route::get('/penjualan/import', [PenjualanController::class, 'import']); // ajax form upload excel
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']); // ajax import excel
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
    });
});
