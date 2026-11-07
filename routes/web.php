<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DetectionHistoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DetectionController;
use App\Http\Controllers\User\HistoryController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('users', UserController::class);

        Route::get('/riwayat-deteksi', [DetectionHistoryController::class, 'index'])
            ->name('detection-histories.index');

        Route::get('/riwayat-deteksi/{detectionHistory}', [DetectionHistoryController::class, 'show'])
            ->name('detection-histories.show');

        Route::get('/laporan-deteksi', [ReportController::class, 'index'])
        ->name('reports.index');
    });

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/deteksi', [DetectionController::class, 'index'])
            ->name('detection');

        Route::post('/deteksi', [DetectionController::class, 'store'])
            ->name('detection.store');
        Route::get('/riwayat', [HistoryController::class, 'index'])
            ->name('history.index');

        Route::get('/riwayat/{id}', [HistoryController::class, 'show'])
            ->name('history.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    Route::put('/password', [PasswordController::class, 'update'])
        ->name('password.update');
});

require __DIR__ . '/auth.php';