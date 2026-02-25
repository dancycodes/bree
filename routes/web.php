<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FounderProfileController;
use App\Http\Controllers\Admin\ProgramActivitiesController;
use App\Http\Controllers\Admin\ProgramsController as AdminProgramsController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsletterController;
use App\Http\Controllers\Public\ProgramsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (Guest only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (Authenticated)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // About — Founder Profile
    Route::get('/a-propos/fondatrice', [FounderProfileController::class, 'edit'])->name('about.founder.edit');
    Route::patch('/a-propos/fondatrice', [FounderProfileController::class, 'update'])->name('about.founder.update');

    // Programs & Activities
    Route::get('/programmes', [AdminProgramsController::class, 'index'])->name('programs.index');
    Route::get('/programmes/{program:slug}/edit', [AdminProgramsController::class, 'edit'])->name('programs.edit');
    Route::patch('/programmes/{program:slug}', [AdminProgramsController::class, 'update'])->name('programs.update');
    Route::get('/programmes/{program:slug}/activites', [ProgramActivitiesController::class, 'index'])->name('programs.activities.index');
    Route::post('/programmes/{program:slug}/activites', [ProgramActivitiesController::class, 'store'])->name('programs.activities.store');
    Route::patch('/programmes/activites/{activity}', [ProgramActivitiesController::class, 'update'])->name('programs.activities.update');
    Route::delete('/programmes/activites/{activity}', [ProgramActivitiesController::class, 'destroy'])->name('programs.activities.destroy');
    Route::post('/programmes/{program:slug}/activites/reorder', [ProgramActivitiesController::class, 'reorder'])->name('programs.activities.reorder');
});

/*
|--------------------------------------------------------------------------
| Public Routes placeholder (home needed for logo link)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('public.home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('public.about');
Route::get('/programmes', [ProgramsController::class, 'index'])->name('public.programs');
Route::get('/programmes/{program:slug}', [ProgramsController::class, 'show'])->name('public.programs.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])
    ->name('newsletter.subscribe')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function (string $locale) {
    $supported = ['fr', 'en'];
    if (in_array($locale, $supported, true)) {
        session()->put('locale', $locale);
    }

    return redirect(url()->previous('/'));
})->name('lang.switch');
