<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\App\Models\Setting::class)) {
            try {
                \Illuminate\Support\Facades\View::share('settings', \App\Models\Setting::pluck('value', 'key')->all());
            } catch (\Exception $e) {
                // Ignore errors during migrations or if table doesn't exist
            }
        }
    }
}
