<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ScheduleController;
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
    Route::get('doctors/{doctor}/assign', [DoctorController::class, 'assign'])->name('doctors.assign');

    Route::resource('educations', EducationController::class)->names('educations');
    Route::resource('experiences', ExperienceController::class)->names('experiences');

    Route::resource('departments', DepartmentController::class)->names('departments');
    Route::get('/departments/{department}/add-doctors', [DepartmentController::class, 'addDoctorForm'])->name('departments.addDoctorForm');
    Route::post('/departments/{department}/add-doctors', [DepartmentController::class, 'addDoctors'])->name('departments.addDoctors');
    Route::resource('schedules', ScheduleController::class)->names('schedules');
    Route::resource('menus', MenuController::class)->names('menus');
    Route::post('modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::post('pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/module/{slug}', [ModuleController::class, 'show'])->name('module.show');
    Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
});
