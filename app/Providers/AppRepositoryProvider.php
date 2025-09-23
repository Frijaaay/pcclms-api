<?php

namespace App\Providers;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\BookRepository;
use App\Repositories\BorrowRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReturnRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\AuthRepositoryInterface;
use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repositories Concrete Binding
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(BorrowRepositoryInterface::class, BorrowRepository::class);
        $this->app->bind(ReturnRepositoryInterface::class, ReturnRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
