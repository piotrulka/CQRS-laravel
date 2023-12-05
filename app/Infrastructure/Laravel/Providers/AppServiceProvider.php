<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;


use App\Domain\Delegation\DelegationRepository;
use App\Domain\User\UserRepository;

use App\Infrastructure\User\UserRepository as InfrastructureUserRepository;
use App\Infrastructure\Delegation\DelegationRepository as InfrastructureDelegationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, InfrastructureUserRepository::class);
        $this->app->bind(DelegationRepository::class, InfrastructureDelegationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
