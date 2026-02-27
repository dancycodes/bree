<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.public', function ($view) {
            $settings = SiteSetting::allSettings();
            $view->with('siteSettings', $settings);
            $view->with('paymentsEnabled', ($settings['payments_enabled'] ?? '0') === '1');
        });

    }
}
