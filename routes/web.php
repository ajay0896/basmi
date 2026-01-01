<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\LaporanController;

// Default redirect
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
})->name('welcome');


Route::get('/about', fn () => view('pages.about'))->name('about');
Route::middleware('guest')->group(function(){
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.process');

    Route::get('/register', [UserAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.process');


});



Route::middleware('role')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    Route::get('/home', [LaporanController::class, 'index'])->name('home');
    Route::get('/laporan', [LaporanController::class, 'jelajah'])->name('laporan');
    Route::get('/laporan-search', [LaporanController::class, 'search'])->name('laporan-search');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::get('aduan/form', [AduanController::class, 'form'])->name('aduan.form');
    Route::post('/laporan', [AduanController::class, 'storeLaporan'])->name('laporan.store');
    Route::get('/aduan', [AduanController::class, 'create'])->name('aduan.create');
    Route::post('/aduan', [AduanController::class, 'store'])->name('aduan.store');
    Route::get('/aduan/confirm', [AduanController::class, 'confirm'])->name('aduan.confirm');
    Route::post('/aduan/submit', [AduanController::class, 'submitFinal'])->name('aduan.submit.final');
    Route::get('/aduan/{id}', [LaporanController::class, 'detail'])->name('aduan.detail');
    Route::get('/aduanku', [AduanController::class, 'index'])->name('aduan.show');


});
