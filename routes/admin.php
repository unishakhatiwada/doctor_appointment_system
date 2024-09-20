<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware(['admin_guest'])->group(function () {
    Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login.page');
    Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login');
});
Route::middleware(['admin_auth:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [DashboardController::class, 'logout'])->name('admin.logout');


    Route::resource('doctors', DoctorController::class)->names('doctors');
    Route::get('admin/doctors/{doctor}/assign', [DoctorController::class, 'assign'])->name('doctors.assign');

    Route::resource('departments', DepartmentController::class)->names('departments');
    Route::get('/departments/{department}/add-doctors', [DepartmentController::class, 'addDoctorForm'])->name('departments.addDoctorForm');
    Route::post('/departments/{department}/add-doctors', [DepartmentController::class, 'addDoctors'])->name('departments.addDoctors');

});
