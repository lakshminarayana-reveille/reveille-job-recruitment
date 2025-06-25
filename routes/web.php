<?php

use App\Http\Controllers\JobApplicationController;
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


Route::get('/job-application', [JobApplicationController::class, 'showForm'])->name('job-application.show');
Route::post('/job-application/step/{step}', [JobApplicationController::class, 'storeStep'])->name('job-application.store-step');
Route::post('/job-application/submit', [JobApplicationController::class, 'submit'])->name('job-application.submit');
Route::post('/job-application/save-draft', [JobApplicationController::class, 'saveDraft'])->name('job-application.save-draft');
Route::post('/job-application/reset', [JobApplicationController::class, 'reset'])->name('job-application.reset');
