<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Interfaces\UserReadableInterface;
use App\Interfaces\UserWritableInterface;
use App\Interfaces\UserDeletableInterface;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserReadableInterface::class, UserService::class);
        $this->app->bind(UserWritableInterface::class, UserService::class);
        $this->app->bind(UserDeletableInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(Carbon::now()->addMinutes(60));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(120));
    }
}
