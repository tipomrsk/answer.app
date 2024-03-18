<?php

namespace App\Providers;

use App\Repositories\{
    FormRepository
};
use App\Repositories\Interfaces\{
    FormRepositoryInterface
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FormRepositoryInterface::class,
            FormRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
