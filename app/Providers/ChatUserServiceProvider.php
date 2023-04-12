<?php

namespace App\Providers;

use App\Services\ChatUser\Contracts\ChatUserRepositoryContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\ChatUser\Repositories\ChatUserRepository;
use App\Services\ChatUser\Services\ChatUserService;
use Illuminate\Support\ServiceProvider;

class ChatUserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChatUserRepositoryContract::class, ChatUserRepository::class);
        $this->app->singleton(ChatUserServiceContract::class, ChatUserService::class);
    }
}
