<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Security\SessionController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\HistoryController;
use App\Http\Controllers\Client\VehicleController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\PasswordResetController;

// ─── Root ────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── Guest Routes ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])
        ->middleware('throttle:login')
        ->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Password reset routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
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
        Route::get('/dashboard',       [ClientDashboard::class, 'index'])->name('dashboard');
        Route::get('/history',         [HistoryController::class, 'index'])->name('history.index');
        Route::get('/vehicles',        [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/payments',        [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/profile/edit',    [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/lots/{lot}/map', [ClientDashboard::class, 'lotMap'])->name('lots.map');
    });
