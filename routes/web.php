<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VoyageurController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;

Route::get('/', [VisitController::class, 'welcome'])->name('welcome');
Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');

Route::middleware('auth')->group(function () {
    Route::post('/visits/{visit}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/visits/{visit}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});


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
    
   
    // --- ZONE ADMIN ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/guides', [AdminController::class, 'guides'])->name('guides');
        Route::patch('/guides/{user}/verify', [AdminController::class, 'verifyGuide'])->name('guides.verify');
        Route::delete('/guides/{user}/reject', [AdminController::class, 'rejectGuide'])->name('guides.reject');
        Route::get('/visits', [AdminController::class, 'visits'])->name('visits');
        Route::delete('/visits/{visit}', [AdminController::class, 'deleteVisit'])->name('visits.delete');
        Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });

    
    Route::middleware(['guide'])->prefix('guide')->group(function () {
        Route::get('/dashboard', [VisitController::class, 'index'])->name('guide.dashboard');
        Route::get('/reservations', [ReservationController::class, 'index'])->name('guide.reservations');
        Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('guide.reservations.update');

        Route::resource('visits', VisitController::class)->except(['show', 'index']);
    });

    // --- ZONE VOYAGEUR ---
    Route::middleware(['voyageur'])->prefix('voyageur')->group(function () {
        Route::get('/dashboard', [VoyageurController::class, 'dashboard'])->name('voyageur.dashboard');
        Route::get('/reservations', [VoyageurController::class, 'reservations'])->name('voyageur.reservations');
        Route::get('/profile', [VoyageurController::class, 'profile'])->name('voyageur.profile');
    });

    Route::post('/visits/{visit}/reserve', [ReservationController::class, 'store'])->name('visits.reserve');

    Route::get('/home', function () {
        // Redirection basée sur le rôle pour la route /home par défaut de Laravel
        $role = auth()->user()->role;
        if ($role === 'guide') return redirect()->route('guide.dashboard');
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        return redirect()->route('voyageur.dashboard');
    })->name('home');

});
