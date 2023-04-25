<?php

namespace App\Providers;

use App\Services\Users\Contracts\UserAvatarServiceContract;
use App\Services\Users\Contracts\UserDtoFactoryContract;
use App\Services\Users\Contracts\UserDtoFormatterContract;
use App\Services\Users\Contracts\UserRepositoryContract;
use App\Services\Users\Contracts\UserServiceContract;
use App\Services\Users\Contracts\UserUpdateOnlineStatusDtoFactoryContract;
use App\Services\Users\Factories\UserDtoFactory;
use App\Services\Users\Factories\UserUpdateOnlineStatusDtoFactory;
use App\Services\Users\Formatters\UserDtoFormatter;
use App\Services\Users\Repositories\UserRepository;
use App\Services\Users\Services\UserAvatarService;
use App\Services\Users\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserDtoFactoryContract::class, UserDtoFactory::class);
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
        $this->app->singleton(UserServiceContract::class, UserService::class);
        $this->app->singleton(UserDtoFormatterContract::class, UserDtoFormatter::class);
        $this->app->singleton(UserAvatarServiceContract::class, UserAvatarService::class);
        $this->app->singleton(UserUpdateOnlineStatusDtoFactoryContract::class, UserUpdateOnlineStatusDtoFactory::class);
    }
}
