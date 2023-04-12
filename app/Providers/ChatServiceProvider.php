<?php

namespace App\Providers;

use App\Services\Chat\Contacts\ChatRepositoryContract;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Contacts\CreateChatDtoFactoryContract;
use App\Services\Chat\Factories\CreateChatDtoFactory;
use App\Services\Chat\Repositories\ChatRepository;
use App\Services\Chat\Services\ChatService;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateChatDtoFactoryContract::class, CreateChatDtoFactory::class);
        $this->app->singleton(ChatServiceContract::class, ChatService::class);
        $this->app->singleton(ChatRepositoryContract::class, ChatRepository::class);
    }
}
