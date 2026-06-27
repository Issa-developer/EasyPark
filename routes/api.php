<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Security\SessionController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;

// ─── Root ────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── Guest Routes ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ─── Logout ───────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Admin Routes ─────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard',  [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/sessions',   [AdminDashboard::class, 'sessions'])->name('sessions');
        Route::get('/users',      [AdminDashboard::class, 'users'])->name('users');
        Route::get('/occupancy',  [AdminDashboard::class, 'occupancy'])->name('occupancy');
        Route::post('/guards',    [AdminDashboard::class, 'createSecurityGuard'])->name('guards.store');
    });

// ─── Security Routes ──────────────────────────────────────
Route::middleware(['auth', 'role:security'])
    ->prefix('security')
    ->name('security.')
    ->group(function () {
        Route::get('/dashboard',  [SessionController::class, 'index'])->name('dashboard');
        Route::post('/entry',     [SessionController::class, 'entry'])->name('entry');
        Route::post('/exit',      [SessionController::class, 'exit'])->name('exit');
    });

// ─── Client Routes ────────────────────────────────────────
Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    });