<?php

namespace App\Providers;

use App\Interfaces\BaseRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
