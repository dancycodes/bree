<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FounderProfileController;
use App\Http\Controllers\Admin\MilestonesController;
use App\Http\Controllers\Admin\NewsArticlesController;
use App\Http\Controllers\Admin\NewsCategoriesController;
use App\Http\Controllers\Admin\PatronProfileController;
use App\Http\Controllers\Admin\ProgramActivitiesController;
use App\Http\Controllers\Admin\ProgramsController as AdminProgramsController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\EventsController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
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
    Route::get('/a-propos/marraine', [PatronProfileController::class, 'edit'])->name('about.patron.edit');
    Route::patch('/a-propos/marraine', [PatronProfileController::class, 'update'])->name('about.patron.update');
    Route::get('/a-propos/jalons', [MilestonesController::class, 'index'])->name('about.milestones.index');
    Route::post('/a-propos/jalons', [MilestonesController::class, 'store'])->name('about.milestones.store');
    Route::patch('/a-propos/jalons/{milestone}', [MilestonesController::class, 'update'])->name('about.milestones.update');
    Route::delete('/a-propos/jalons/{milestone}', [MilestonesController::class, 'destroy'])->name('about.milestones.destroy');

    // Programs & Activities
    Route::get('/programmes', [AdminProgramsController::class, 'index'])->name('programs.index');
    Route::get('/programmes/{program:slug}/edit', [AdminProgramsController::class, 'edit'])->name('programs.edit');
    Route::patch('/programmes/{program:slug}', [AdminProgramsController::class, 'update'])->name('programs.update');
    Route::get('/programmes/{program:slug}/activites', [ProgramActivitiesController::class, 'index'])->name('programs.activities.index');
    Route::post('/programmes/{program:slug}/activites', [ProgramActivitiesController::class, 'store'])->name('programs.activities.store');
    Route::patch('/programmes/activites/{activity}', [ProgramActivitiesController::class, 'update'])->name('programs.activities.update');
    Route::delete('/programmes/activites/{activity}', [ProgramActivitiesController::class, 'destroy'])->name('programs.activities.destroy');
    Route::post('/programmes/{program:slug}/activites/reorder', [ProgramActivitiesController::class, 'reorder'])->name('programs.activities.reorder');

    // News Articles
    Route::get('/actualites', [NewsArticlesController::class, 'index'])->name('news.index');
    Route::get('/actualites/creer', [NewsArticlesController::class, 'create'])->name('news.create');
    Route::post('/actualites', [NewsArticlesController::class, 'store'])->name('news.store');
    Route::get('/actualites/{article:slug}/modifier', [NewsArticlesController::class, 'edit'])->name('news.edit');
    Route::patch('/actualites/{article:slug}', [NewsArticlesController::class, 'update'])->name('news.update');
    Route::delete('/actualites/{article:slug}', [NewsArticlesController::class, 'destroy'])->name('news.destroy');

    // News Categories
    Route::get('/actualites/categories', [NewsCategoriesController::class, 'index'])->name('news.categories.index');
    Route::post('/actualites/categories', [NewsCategoriesController::class, 'store'])->name('news.categories.store');
    Route::patch('/actualites/categories/{category}', [NewsCategoriesController::class, 'update'])->name('news.categories.update');
    Route::delete('/actualites/categories/{category}', [NewsCategoriesController::class, 'destroy'])->name('news.categories.destroy');
});

/*
|--------------------------------------------------------------------------
| Public Routes placeholder (home needed for logo link)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('public.home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('public.about');
Route::get('/actualites', [NewsController::class, 'index'])->name('public.news');
Route::get('/actualites/{article:slug}', [NewsController::class, 'show'])->name('public.news.show');
Route::get('/evenements', [EventsController::class, 'index'])->name('public.events');
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
