<?php

namespace App\Services\ChatMessageStatus\Contracts;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use Throwable;

interface ChatMessageStatusRepositoryContract
{
    /**
     * @param ChatMessageStatusCreateDto $dto
     *
     * @return void
     * @throws Throwable
     */
    public function create(ChatMessageStatusCreateDto $dto): void;
}
