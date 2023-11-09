<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //menampilkan data buku

    Route::get('/buku', [BukuController::class, 'index'])->name('buku');

    Route::middleware('admin')->group(function () {
    Route::get('/bukuCreate', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

    //menuju halaman edit
    Route::get('/bukuEdit/{id}', [BukuController::class, 'edit'])->name('bukuEdit');

    //menyimpan hasil edit
    Route::post('/buku.update/{id}', [BukuController::class, 'update'])->name('buku.update');

    Route::post('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});

require __DIR__.'/auth.php';