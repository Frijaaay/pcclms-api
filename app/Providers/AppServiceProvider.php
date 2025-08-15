<?php

namespace App\Providers;

use App\Services\BookService;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\BookServiceInterface;
use App\Contracts\Services\UserServiceInterface;

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
        $this->app->bind(BookServiceInterface::class, BookService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        // if(env('APP_ENV') !== 'local') {
            // $url->forceHttps();
        // }
    }
}
