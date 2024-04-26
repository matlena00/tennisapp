<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('auth');

// Routing used only by admin
Route::middleware('can:isAdmin')->group(function () {
    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');


    // Courts
    Route::get('/courts', [CourtController::class, 'index'])
        ->name('courts.index');

    Route::get('/courts/create', [CourtController::class, 'create'])
        ->name('courts.create');

    Route::post('/courts', [CourtController::class, 'store'])
        ->name('courts.store');

    Route::get('/courts/{court}', [CourtController::class, 'show'])
        ->name('courts.show');

    Route::get('/courts/{court}/edit', [CourtController::class, 'edit'])
        ->name('courts.edit');

    Route::put('/courts/{court}', [CourtController::class, 'update'])
        ->name('courts.update');

    Route::delete('/courts/{court}', [CourtController::class, 'destroy'])
        ->name('courts.destroy');
});

Route::middleware('can:isUser')->group(function () {
    // Reservations
    Route::get('/reservations/index', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reserve/{court}', [ReservationController::class, 'create'])->name('reservations.create');

    Route::get('/reservation/confirm/{court}/{start}/{end}', [ReservationController::class, 'confirm'])->name('reservation.confirm');

    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // Courts
    Route::get('/courts/{court}/availability', [CourtController::class, 'generateAvailableSlots'])
        ->name('court.availability');

    Route::get('/courts/{court}/slots', [CourtController::class, 'slots'])
        ->name('courts.slots');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
