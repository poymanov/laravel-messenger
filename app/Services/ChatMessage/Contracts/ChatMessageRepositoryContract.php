<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use Throwable;

interface ChatMessageRepositoryContract
{
    /**
     * @param ChatMessageCreateDto $dto
     *
     * @return void
     * @throws Throwable
     */
    public function create(ChatMessageCreateDto $dto): void;
}
