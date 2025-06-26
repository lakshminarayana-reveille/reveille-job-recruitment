<?php

use App\Http\Controllers\RecruitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('recruitment.show');
});

Route::get('/recruitment', [RecruitmentController::class, 'showForm'])->name('recruitment.show');
Route::post('/recruitment/step/{step}', [RecruitmentController::class, 'storeStep'])->name('recruitment.store-step');
Route::post('/recruitment/submit', [RecruitmentController::class, 'submit'])->name('recruitment.submit');
Route::post('/recruitment/reset', [RecruitmentController::class, 'reset'])->name('recruitment.reset');
