<?php

namespace App\Providers;

use App\Repositories\{AnswerRepository, FormRepository, QuestionRepository};
use App\Repositories\Interfaces\{AnswerRepositoryInterface, FormRepositoryInterface, QuestionnaireRepositoryInterface};
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
            QuestionRepository::class
        );

        $this->app->bind(
            AnswerRepositoryInterface::class,
            AnswerRepository::class
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
