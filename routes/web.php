<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\RecruitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('recruitment.show');
});

Route::get('/admin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/recruitment', [RecruitmentController::class, 'showForm'])->name('recruitment.show');
Route::post('/recruitment/step/{step}', [RecruitmentController::class, 'storeStep'])->name('recruitment.store-step');
Route::post('/recruitment/submit', [RecruitmentController::class, 'submit'])->name('recruitment.submit');
Route::post('/recruitment/reset', [RecruitmentController::class, 'reset'])->name('recruitment.reset');

// Admin routes
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');

// php artisan make:model Admin -m
// php artisan migrate
// php artisan make:migration create_admins_table --create=admins
// php artisan db:seed --class=AdminSeeder
