<?php

namespace App\Providers;

use App\Services\Chat\Contacts\ChatDtoFactoryContract;
use App\Services\Chat\Contacts\ChatRepositoryContract;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Contacts\ChatShowProcessResultDtoFactoryContract;
use App\Services\Chat\Contacts\ChatShowServiceContract;
use App\Services\Chat\Contacts\CreateChatDtoFactoryContract;
use App\Services\Chat\Factories\ChatDtoFactory;
use App\Services\Chat\Factories\ChatShowProcessResultDtoFactory;
use App\Services\Chat\Factories\CreateChatDtoFactory;
use App\Services\Chat\Repositories\ChatRepository;
use App\Services\Chat\Services\ChatService;
use App\Services\Chat\Services\ChatShowService;
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
        $this->app->singleton(ChatDtoFactoryContract::class, ChatDtoFactory::class);
        $this->app->singleton(ChatShowProcessResultDtoFactoryContract::class, ChatShowProcessResultDtoFactory::class);
        $this->app->singleton(ChatShowServiceContract::class, ChatShowService::class);
    }
}
