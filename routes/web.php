<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VisitController; // ← Notre nouveau contrôleur

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 🟢 ROUTES POUR LES INVITÉS (non connectés)
Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Connexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// 🔴 ROUTES PROTÉGÉES (nécessite d'être connecté)
Route::middleware(['auth'])->group(function () {
    
    // Déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // --- ZONE ADMIN ---
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // --- ZONE GUIDE ---
    Route::middleware(['guide'])->group(function () {
        Route::get('/guide/dashboard', function () {
            return view('guide.dashboard');
        })->name('guide.dashboard');

        // 📋 CRUD VISITES
        // Route::resource() crée automatiquement toutes les routes CRUD :
        //   GET  /visits          → index()   (liste)
        //   GET  /visits/create   → create()  (formulaire création)
        //   POST /visits          → store()   (enregistrement)
        //   GET  /visits/{id}/edit → edit()   (formulaire modification)
        //   PUT  /visits/{id}     → update()  (mise à jour)
        //   DELETE /visits/{id}  → destroy() (suppression)
        Route::resource('visits', VisitController::class)->except(['show']);
    });

    // --- ZONE VOYAGEUR ---
    Route::get('/home', function () {
        return view('home');
    })->name('home');

});
