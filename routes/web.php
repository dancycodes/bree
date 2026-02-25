<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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
});

/*
|--------------------------------------------------------------------------
| Public Routes placeholder (home needed for logo link)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('public.home');
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
