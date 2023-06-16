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
        $this->app->bind(\App\Repository\Contract\ProjectRepositoryInterface::class, \App\Repository\ProjectRepository::class);
        $this->app->bind(\App\Repository\Contract\TaskRepositoryInterface::class, \App\Repository\TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
