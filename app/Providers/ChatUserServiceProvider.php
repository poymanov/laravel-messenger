<?php

namespace App\Providers;

use App\Services\ChatUser\Contracts\ChatUserRepositoryContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\ChatUser\Contracts\UserChatUserDtoFactoryContract;
use App\Services\ChatUser\Contracts\UserChatUserDtoFormatterContract;
use App\Services\ChatUser\Factories\UserChatUserDtoFactory;
use App\Services\ChatUser\Formatters\UserChatUserDtoFormatter;
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
        $this->app->singleton(UserChatUserDtoFactoryContract::class, UserChatUserDtoFactory::class);
        $this->app->singleton(UserChatUserDtoFormatterContract::class, UserChatUserDtoFormatter::class);
    }
}
