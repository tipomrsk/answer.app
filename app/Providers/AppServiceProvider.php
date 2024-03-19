<?php

namespace App\Providers;

use App\Repositories\{AnswerRepository, FormRepository, QuestionRepository, UserRepository};
use App\Repositories\Interfaces\{AnswerRepositoryInterface,
    FormRepositoryInterface,
    QuestionnaireRepositoryInterface,
    UserRepositoryInterface};
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

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
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
