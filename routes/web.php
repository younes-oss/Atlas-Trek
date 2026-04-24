<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VisitController; // ← Notre nouveau contrôleur

Route::get('/', [VisitController::class, 'welcome'])->name('welcome');


Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Connexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    
   
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
   
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    
    Route::middleware(['guide'])->group(function () {
        Route::get('/guide/dashboard', [VisitController::class, 'index'])->name('guide.dashboard');

        Route::resource('visits', VisitController::class)->except(['show']);
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');

});
