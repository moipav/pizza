<?php

namespace App\Providers;

use App\Actions\Cart\ApiCartResolver;
use App\Actions\Cart\WebCartResolver;
use App\Contracts\CartResolver;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Динамическая привязка
        $this->app->bind(CartResolver::class, function ($app) {
            if (Request::is('api/*') || Request::expectsJson()) {
                return new ApiCartResolver();
            }
            return new WebCartResolver();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
