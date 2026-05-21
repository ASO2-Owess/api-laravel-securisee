<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

// ── Routes publiques (sans authentification) ──────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ── Routes protégées (token requis) ───────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/profil',   [AuthController::class, 'profil']);

    // Produits — lecture (tous les utilisateurs connectés)
    Route::get('/produits',      [ProduitController::class, 'index']);
    Route::get('/produits/{id}', [ProduitController::class, 'show']);

    // Produits — écriture (admin seulement)
    Route::middleware('role:admin')->group(function () {
        Route::post('/produits',          [ProduitController::class, 'store']);
        Route::put('/produits/{id}',      [ProduitController::class, 'update']);
        Route::delete('/produits/{id}',   [ProduitController::class, 'destroy']);
    });
});
