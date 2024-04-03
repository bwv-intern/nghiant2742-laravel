<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\CommonObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations(); 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(CommonObserver::class);
    }
}
