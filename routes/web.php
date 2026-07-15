<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\MoodLogController;
use App\Http\Controllers\SpecializationController;
// Existing login view
Route::view('/login', 'auth.login');

// Existing home page
Route::get('/', [HomeController::class, 'index']);

// Existing patient registration
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');


// Patient routes
Route::middleware('auth:patient')->group(function () {
    Route::get('/patient/dashboard', [App\Http\Controllers\PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::post('/patient/moodlog', [App\Http\Controllers\MoodLogController::class, 'store'])->name('moodlog.store');
    Route::post('/patient/book', [App\Http\Controllers\AppointmentController::class, 'book'])->name('appointment.book');
    Route::post('/patient/followup/confirm/{followup}', [FollowUpController::class, 'confirm'])->name('followup.confirm');
    Route::get('/patient/profile/edit', [PatientController::class, 'editProfile'])->name('patient.profile.edit');
Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.profile.update');
Route::get('/patient/moodlog/{id}/edit', [MoodLogController::class,'edit'])->name('moodlog.edit');
Route::post('/patient/moodlog/{id}/update', [MoodLogController::class,'update'])->name('moodlog.update');
Route::post('/patient/moodlog/{id}/delete', [MoodLogController::class,'destroy'])->name('moodlog.delete');
Route::get('/patient/profile/edit',[PatientController::class,'editProfile'])->name('patient.profile.edit');
Route::post('/patient/profile/update',[PatientController::class,'updateProfile'])->name('patient.profile.update');
});

// Therapist routes
Route::middleware('auth:therapist')->group(function () {
    Route::get('/therapist/dashboard', [App\Http\Controllers\TherapistController::class, 'dashboard'])->name('therapist.dashboard');
    Route::post('/therapist/sessionnote', [App\Http\Controllers\SessionNoteController::class, 'store'])->name('sessionnote.store');
    Route::post('/therapist/cancel/{session}', [App\Http\Controllers\CancellationController::class, 'store'])->name('cancellation.store');
    Route::post('/therapist/session/{session}/cancel', [CancellationController::class, 'store'])->name('therapist.session.cancel');
    Route::post('/therapist/followup/create', [FollowUpController::class, 'store'])->name('followup.store');
    Route::get('/therapist/patient/{patient}/mood-trends', [MoodLogController::class, 'trends'])->name('moodlog.trends');
    Route::get('/therapist/patient/{id}',[TherapistController::class,'viewPatient'])->name('therapist.patient.view');
    Route::post('/therapist/session/{id}/reschedule',[TherapistController::class,'reschedule'])->name('therapist.session.reschedule');
    Route::post('/therapist/availability',[TherapistController::class,'updateAvailability'])->name('therapist.availability');
    Route::post('/therapist/session/{id}/reschedule',[AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
    Route::get('/therapist/availability',[TherapistController::class,'editAvailability'])->name('therapist.availability');
    Route::post('/therapist/availability',[TherapistController::class,'updateAvailability'])->name('therapist.availability.update');
    Route::post('/therapist/session/{session}/reschedule',[TherapistController::class, 'reschedule'])->name('therapist.session.reschedule');
    });

Route::middleware('auth:admin')->group(function () {

    // Admin Dashboard
    Route::get(
        '/admin/dashboard',
        [AdminController::class, 'dashboard']
    )->name('admin.dashboard');

    // Verify Therapist
    Route::post(
        '/admin/therapist/verify/{id}',
        [AdminController::class, 'verifyTherapist']
    )->name('admin.therapist.verify');

    // Manage Specializations
    Route::resource(
        'specializations',
        SpecializationController::class
    );

});
