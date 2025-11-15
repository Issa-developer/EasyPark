<?php

use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\ParkingHistoryController;
use App\Http\Controllers\Client\VehicleController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
// Route::middleware(['auth'])     // you can also add a 'client' gate if you want
//     ->prefix('app')
//     ->name('client.')
//     ->group(function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//         Route::get('/history', [ParkingHistoryController::class, 'index'])->name('history.index');

//         Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
//         Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
//         Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
//         Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

//         Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

//         Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//         Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     });

// after login redirect users here
// in your Login controller:
// return redirect()->route('client.dashboard');


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboards
Route::middleware(['auth', CheckRole::class . ':client'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('client.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


 // Parking History
 Route::get('/history', [DashboardController::class, 'history'])
 ->name('client.history.index');    
});

 // My Vehicles
 Route::get('/vehicles', [VehicleController::class, 'index'])
 ->name('client.vehicles.index');

 
   // Payments
 Route::get('/payments', [PaymentController::class, 'index'])
  ->name('client.payments.index');

  // Profile
 Route::get('/profile/edit', [ProfileController::class, 'edit'])
  ->name('client.profile.edit');

Route::post('/profile/update', [ProfileController::class, 'update'])
  ->name('client.profile.update');

// Default redirect
Route::get('/', function () {
    return redirect()->route('login');
});
