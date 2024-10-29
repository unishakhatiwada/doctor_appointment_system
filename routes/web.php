<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Default user routes
Route::get('/', function () {
    return view('welcome')->name('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [DepartmentController::class, 'publicIndex'])->name('departments.index');
Route::get('/departments/{id}/doctors', [AppointmentController::class, 'getDoctors'])->name('departments.showDoctors');
Route::get('/appointments/{doctor}/available-slots', [AppointmentController::class, 'availableSlots'])->name('appointments.availableSlots');
Route::get('/appointments/registration/{doctor}/{schedule}/{time}', [AppointmentController::class, 'showRegistrationForm'])->name('appointments.registration');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments', [AppointmentController::class, 'create'])->name('appointments.create');
Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/districts/{provinceId}', function ($provinceId) {
    return DB::table('districts')->where('province_id', $provinceId)->get();
});

Route::get('/municipalities/{districtId}', function ($districtId) {
    return DB::table('municipalities')->where('district_id', $districtId)->get();
});
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
