<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('isGuest')->group(function () {
    Route::get('/', [UserController::class, 'showLogin'])->name('login.auth');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.proses');
});


Route::middleware('isLogin')->group(function () {
    Route::get('/landing', [UserController::class, 'landing'])->name('landing_page');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware('isAdmin')->group(function () {
        Route::get('/order', [OrderController::class, 'indexAdmin'])->name('peminjaman.admin');
        Route::get('/order/export-excel', [OrderController::class, 'exportExcel'])->name('peminjaman.admin.export');
        Route::prefix('books')->name('book.')->group(function () {
            Route::get('/create', [BookController::class, 'create'])->name('create'); // Halaman untuk membuat buku baru
            Route::post('/store', [BookController::class, 'store'])->name('store'); // Menyimpan buku baru
            Route::get('/data', [BookController::class, 'index'])->name('index'); // Daftar buku
            Route::get('/{id}', [BookController::class, 'edit'])->name('edit'); // Halaman edit buku berdasarkan ID
            Route::patch('/{id}', [BookController::class, 'update'])->name('update'); // Memperbarui buku berdasarkan ID
            Route::delete('/{id}', [BookController::class, 'destroy'])->name('destroy'); // Menghapus buku berdasarkan ID
        });
        Route::prefix('akun')->name('akun.')->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/data', [UserController::class, 'index'])->name('index');
            Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
        // Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export.excel');
    });

    Route::middleware('isUser')->group(function () {
        Route::prefix('pinjam')->name('pinjam.')->group(function () {
            Route::get('/data', [OrderController::class, 'index'])->name('index'); // Daftar buku
            Route::get('/create', [OrderController::class, 'create'])->name('create'); // Form peminjaman
            Route::post('/pinjam', [OrderController::class, 'store'])->name('pinjam.store');
            Route::get('/{order}', [OrderController::class, 'print'])->name('show'); // Menampilkan detail peminjaman
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit'); // Form edit peminjaman
            Route::put('/{order}', [OrderController::class, 'update'])->name('update'); // Mengupdate peminjaman
            Route::get('/print-pdf/{id}', [OrderController::class, 'printPdf'])->name('print.pdf');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        });
    });
});
