<?php

namespace App\Services\ChatMessageStatus\Contracts;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use Throwable;

interface ChatMessageStatusServiceContract
{
    /**
     * @param ChatMessageStatusCreateDto $dto
     *
     * @return void
     * @throws Throwable
     */
    public function create(ChatMessageStatusCreateDto $dto): void;
}
