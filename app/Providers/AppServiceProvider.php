<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Force HTTPS in production (Render)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Share settings with all frontend views
        View::composer(['layouts.frontend', 'home', 'contact', 'projects.*'], function ($view) {
            $view->with('settings', Setting::instance());
        });
    }
}
