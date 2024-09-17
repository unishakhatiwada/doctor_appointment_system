<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware(['admin_guest'])->group(function () {
    Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login.page');
    Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login');
});
Route::middleware(['admin_auth:admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/logout', [DashboardController::class, 'logout'])->name('admin.logout');

});
