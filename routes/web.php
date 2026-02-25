<?php

use App\Http\Controllers\Admin\AdminContactMessagesController;
use App\Http\Controllers\Admin\AdminDonationsController;
use App\Http\Controllers\Admin\AdminNewsletterController;
use App\Http\Controllers\Admin\AdminPartnersController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventsController as AdminEventsController;
use App\Http\Controllers\Admin\FounderProfileController;
use App\Http\Controllers\Admin\GalleryAlbumsController;
use App\Http\Controllers\Admin\GalleryPhotosController;
use App\Http\Controllers\Admin\MilestonesController;
use App\Http\Controllers\Admin\NewsArticlesController;
use App\Http\Controllers\Admin\NewsCategoriesController;
use App\Http\Controllers\Admin\PatronProfileController;
use App\Http\Controllers\Admin\ProgramActivitiesController;
use App\Http\Controllers\Admin\ProgramsController as AdminProgramsController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\DonationController;
use App\Http\Controllers\Public\EventsController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\NewsletterController;
use App\Http\Controllers\Public\PartnersController;
use App\Http\Controllers\Public\ProgramsController;
use App\Http\Controllers\Public\VolunteerController;
use App\Http\Controllers\Public\WebhookController;
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
    Route::post('/dashboard/refresh', [DashboardController::class, 'refresh'])->name('dashboard.refresh');

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

    // Gallery Albums
    Route::get('/galerie/albums', [GalleryAlbumsController::class, 'index'])->name('gallery.albums.index');
    Route::get('/galerie/albums/creer', [GalleryAlbumsController::class, 'create'])->name('gallery.albums.create');
    Route::post('/galerie/albums', [GalleryAlbumsController::class, 'store'])->name('gallery.albums.store');
    Route::get('/galerie/albums/{album:slug}/modifier', [GalleryAlbumsController::class, 'edit'])->name('gallery.albums.edit');
    Route::patch('/galerie/albums/{album:slug}', [GalleryAlbumsController::class, 'update'])->name('gallery.albums.update');
    Route::delete('/galerie/albums/{album:slug}', [GalleryAlbumsController::class, 'destroy'])->name('gallery.albums.destroy');

    // Gallery Photos
    Route::get('/galerie/albums/{album:slug}/photos', [GalleryPhotosController::class, 'index'])->name('gallery.albums.photos.index');
    Route::post('/galerie/albums/{album:slug}/photos', [GalleryPhotosController::class, 'store'])->name('gallery.albums.photos.store');
    Route::patch('/galerie/photos/{photo}', [GalleryPhotosController::class, 'updateCaption'])->name('gallery.albums.photos.updateCaption');
    Route::post('/galerie/albums/{album:slug}/photos/reorder', [GalleryPhotosController::class, 'reorder'])->name('gallery.albums.photos.reorder');
    Route::delete('/galerie/photos/{photo}', [GalleryPhotosController::class, 'destroy'])->name('gallery.albums.photos.destroy');

    // Events
    Route::get('/evenements', [AdminEventsController::class, 'index'])->name('events.index');
    Route::get('/evenements/creer', [AdminEventsController::class, 'create'])->name('events.create');
    Route::post('/evenements', [AdminEventsController::class, 'store'])->name('events.store');
    Route::get('/evenements/{event:slug}/modifier', [AdminEventsController::class, 'edit'])->name('events.edit');
    Route::patch('/evenements/{event:slug}', [AdminEventsController::class, 'update'])->name('events.update');
    Route::delete('/evenements/{event:slug}', [AdminEventsController::class, 'destroy'])->name('events.destroy');
    Route::get('/evenements/{event:slug}/inscriptions', [AdminEventsController::class, 'registrations'])->name('events.registrations');
    Route::get('/evenements/{event:slug}/inscriptions/export', [AdminEventsController::class, 'exportRegistrations'])->name('events.registrations.export');

    // News Articles
    Route::get('/actualites', [NewsArticlesController::class, 'index'])->name('news.index');
    Route::get('/actualites/creer', [NewsArticlesController::class, 'create'])->name('news.create');
    Route::post('/actualites', [NewsArticlesController::class, 'store'])->name('news.store');
    Route::get('/actualites/{article:slug}/modifier', [NewsArticlesController::class, 'edit'])->name('news.edit');
    Route::patch('/actualites/{article:slug}', [NewsArticlesController::class, 'update'])->name('news.update');
    Route::delete('/actualites/{article:slug}', [NewsArticlesController::class, 'destroy'])->name('news.destroy');

    // Donations
    Route::match(['GET', 'POST'], '/dons', [AdminDonationsController::class, 'index'])->name('donations.index');

    // Roles
    Route::get('/roles', [AdminRolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/creer', [AdminRolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [AdminRolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/modifier', [AdminRolesController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [AdminRolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [AdminRolesController::class, 'destroy'])->name('roles.destroy');

    // Users
    Route::match(['GET', 'POST'], '/utilisateurs', [AdminUsersController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/creer', [AdminUsersController::class, 'create'])->name('users.create');
    Route::post('/utilisateurs', [AdminUsersController::class, 'store'])->name('users.store');
    Route::get('/utilisateurs/{user}/modifier', [AdminUsersController::class, 'edit'])->name('users.edit');
    Route::patch('/utilisateurs/{user}', [AdminUsersController::class, 'update'])->name('users.update');
    Route::post('/utilisateurs/{user}/desactiver', [AdminUsersController::class, 'disable'])->name('users.disable');
    Route::post('/utilisateurs/{user}/activer', [AdminUsersController::class, 'enable'])->name('users.enable');
    Route::delete('/utilisateurs/{user}', [AdminUsersController::class, 'destroy'])->name('users.destroy');

    // Newsletter Subscribers
    Route::get('/newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{subscriber}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/newsletter/export', [AdminNewsletterController::class, 'exportCsv'])->name('newsletter.export');

    // Contact Messages
    Route::get('/messages', [AdminContactMessagesController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}', [AdminContactMessagesController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [AdminContactMessagesController::class, 'destroy'])->name('messages.destroy');

    // Partners
    Route::get('/partenaires', [AdminPartnersController::class, 'index'])->name('partners.index');
    Route::get('/partenaires/creer', [AdminPartnersController::class, 'create'])->name('partners.create');
    Route::post('/partenaires', [AdminPartnersController::class, 'store'])->name('partners.store');
    Route::get('/partenaires/{partner}/modifier', [AdminPartnersController::class, 'edit'])->name('partners.edit');
    Route::patch('/partenaires/{partner}', [AdminPartnersController::class, 'update'])->name('partners.update');
    Route::delete('/partenaires/{partner}', [AdminPartnersController::class, 'destroy'])->name('partners.destroy');
    Route::post('/partenaires/reorder', [AdminPartnersController::class, 'reorder'])->name('partners.reorder');

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
Route::get('/evenements/{event:slug}', [EventsController::class, 'show'])->name('public.events.show');
Route::post('/evenements/{event:slug}/inscription', [EventsController::class, 'register'])
    ->name('public.events.register')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::get('/galerie', [GalleryController::class, 'index'])->name('public.gallery');
Route::get('/galerie/{album:slug}', [GalleryController::class, 'show'])->name('public.gallery.show');
Route::get('/partenaires', [PartnersController::class, 'index'])->name('public.partners');
Route::post('/partenaires/candidater', [PartnersController::class, 'storePartnership'])
    ->name('public.partners.store')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::get('/benevoles', [VolunteerController::class, 'index'])->name('public.volunteers');
Route::post('/benevoles/candidater', [VolunteerController::class, 'store'])
    ->name('public.volunteers.store')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::get('/programmes', [ProgramsController::class, 'index'])->name('public.programs');
Route::get('/faire-un-don', [DonationController::class, 'index'])->name('public.donate');
Route::post('/faire-un-don/choisir-montant', [DonationController::class, 'selectAmount'])->name('public.donate.selectAmount');
Route::post('/faire-un-don/valider-montant', [DonationController::class, 'validateAmount'])->name('public.donate.validateAmount');
Route::post('/faire-un-don/initier-paiement', [DonationController::class, 'initPayment'])->name('public.donate.initPayment');
Route::post('/faire-un-don/charger-carte', [DonationController::class, 'chargeCard'])->name('public.donate.chargeCard');
Route::post('/faire-un-don/authentifier', [DonationController::class, 'authenticateCharge'])->name('public.donate.authenticateCharge');
Route::get('/don/merci', [DonationController::class, 'successPage'])->name('public.donate.merci');
Route::get('/don/callback-3ds', [DonationController::class, 'verifyPayment'])->name('public.donate.verify3ds');
Route::post('/faire-un-don/promesse', [DonationController::class, 'storePledge'])
    ->name('public.donate.pledge')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::post('/faire-un-don/don-en-nature', [DonationController::class, 'storeInKind'])
    ->name('public.donate.inkind')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::post('/webhook/flutterwave', [WebhookController::class, 'flutterwave'])->name('webhook.flutterwave');
Route::get('/programmes/{program:slug}', [ProgramsController::class, 'show'])->name('public.programs.show');

Route::get('/contact', [ContactController::class, 'index'])->name('public.contact');
Route::post('/contact/envoyer', [ContactController::class, 'store'])
    ->name('public.contact.store')
    ->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);

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
