<?php

namespace App\Providers;

use App\Repositories\{FormRepository, QuestionRepository};
use App\Repositories\Interfaces\{FormRepositoryInterface, QuestionnaireRepositoryInterface};
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

        $this->app->bind(
            QuestionnaireRepositoryInterface::class,
            QuestionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
