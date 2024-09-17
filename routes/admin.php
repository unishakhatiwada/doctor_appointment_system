<?php
use Illuminate\Support\Facades\Route;

// Admin routes
Route::prefix('admin')->group(function (){
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');
//        Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
//        Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class);
    });
});
