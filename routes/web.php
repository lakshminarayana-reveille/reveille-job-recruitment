<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\Admin\DashboardController;
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
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/applications', [DashboardController::class, 'index'])->name('applications');
    Route::get('/applications/{id}', [DashboardController::class, 'showJobApplication'])->name('applications.show');
    Route::post('/applications/{id}/response', [DashboardController::class, 'storeResponse'])->name('applications.response.store');

    Route::get('/user-management', [DashboardController::class, 'userManagement'])->name('userManagement');
    Route::post('/user-managment/create', [DashboardController::class, 'createUser'])->name('userManagement.create');
    Route::post('/user-management/update/{id}', [DashboardController::class, 'updateUser'])->name('userManagement.update');
});

// php artisan make:model Admin -m
// php artisan migrate
// php artisan make:migration create_admins_table --create=admins
// php artisan db:seed --class=AdminSeeder
// php artisan make:middleware AdminAccessMiddleware
// php artisan route:clear
// php artisan storage:link
