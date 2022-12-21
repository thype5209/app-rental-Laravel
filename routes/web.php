<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'cors','role:2,1'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Controller Mobil
    Route::group(['prefix'=> 'Mobil', 'as'=> 'Mobil.'],function(){
        Route::controller(MobilController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/Form/Status', 'StatusModal')->name('StatusModal');
            Route::put('/update/Status/{id}', 'StatusUpdate')->name('StatusUpdate');
            Route::get('/Form/Mobil', 'create')->name('create');
            Route::post('/Form/store', 'store')->name('store');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/detail/{id}', 'show')->name('show');
            Route::put('/Update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            Route::get('/GetIDMobil/{id}', 'GetIDMobil')->name('GetIDMobil');
        });
    });

    // Controller Sewa
    Route::group(['prefix'=> 'Sewa', 'as'=> 'Sewa.'],function(){
        Route::controller(SewaController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/Riwayat/Penyewaan', 'riwayat')->name('riwayat');
            Route::put('/update/Status/{id}', 'StatusUpdate')->name('StatusUpdate');
            Route::get('/Form/Mobil', 'create')->name('create');
            Route::post('/Form/store', 'store')->name('store');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Detail/{id}', 'show')->name('show');
            Route::get('/detail/{id}', 'show')->name('show');
            Route::put('/Update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            Route::post('/Formulir' , 'formulir')->name('formulir');
            Route::put('/updateStatusModal/{id}' , 'updateStatusModal')->name('updateStatusModal');
        });
    });

    // Controller Laporan
    Route::group(['prefix'=> 'Laporan', 'as'=> 'Laporan.'],function(){
        Route::controller(LaporanController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/CetakSewa', 'saveSewaCetak')->name('saveSewaDanCetak');
            Route::post('/saveSewa', 'saveSewa')->name('saveSewa');
        });
    });
    // Controller Pengguna
    Route::group(['prefix'=> 'Pengguna', 'as'=> 'Pengguna.'],function(){
        Route::controller(PenggunaController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/NIK', 'CariNIK')->name('CariNIK');
            Route::get('/GetID{id}', 'GetID')->name('GetID');
        });
    });
    Route::group(['prefix'=> 'Sopir', 'as'=> 'Sopir.'],function(){
        Route::controller(SopirController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/Form/Sopir', 'create')->name('create');
            Route::post('/Form/store', 'store')->name('store');
            Route::get('/Form/edit/{id}', 'edit')->name('edit');
            Route::put('/Form/update/{id}', 'update')->name('update');
            Route::get('/Form/show/{id}', 'show')->name('show');
            Route::delete('/Form/destroy/{id}', 'destroy')->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';


