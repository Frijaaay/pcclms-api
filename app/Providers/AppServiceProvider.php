<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceInterface;
use App\Services\UserService;
use App\Contracts\Services\UserServiceInterface;
use App\Services\AuthService;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Services Concrete Binding
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        if(env('APP_ENV') !== 'local') {
            $url->forceHttps();
        }
    }
}
