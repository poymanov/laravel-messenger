<?php

namespace App\Providers;

use App\Services\ChatMessage\Contracts\ChatMessageCreateDtoFactoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessage\Factories\ChatMessageCreateDtoFactory;
use App\Services\ChatMessage\Repositories\ChatMessageRepository;
use App\Services\ChatMessage\Services\ChatMessageService;
use Illuminate\Support\ServiceProvider;

class ChatMessageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChatMessageCreateDtoFactoryContract::class, ChatMessageCreateDtoFactory::class);
        $this->app->singleton(ChatMessageRepositoryContract::class, ChatMessageRepository::class);
        $this->app->singleton(ChatMessageServiceContract::class, ChatMessageService::class);
    }
}
