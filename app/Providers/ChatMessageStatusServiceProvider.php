<?php

namespace App\Providers;

use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusCreateDtoFactoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusNotReadCountDtoFactoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusRepositoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatMessageStatus\Factories\ChatMessageStatusCreateDtoFactory;
use App\Services\ChatMessageStatus\Factories\ChatMessageStatusNotReadCountDtoFactory;
use App\Services\ChatMessageStatus\Repositories\ChatMessageStatusRepository;
use App\Services\ChatMessageStatus\Services\ChatMessageStatusService;
use Illuminate\Support\ServiceProvider;

class ChatMessageStatusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChatMessageStatusCreateDtoFactoryContract::class, ChatMessageStatusCreateDtoFactory::class);
        $this->app->singleton(ChatMessageStatusRepositoryContract::class, ChatMessageStatusRepository::class);
        $this->app->singleton(ChatMessageStatusServiceContract::class, ChatMessageStatusService::class);
        $this->app->singleton(ChatMessageStatusNotReadCountDtoFactoryContract::class, ChatMessageStatusNotReadCountDtoFactory::class);
    }
}
