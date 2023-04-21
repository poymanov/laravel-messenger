<?php

namespace App\Services\ChatMessageStatus\Contracts;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusNotReadCountDto;
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

    /**
     * @param int $userId
     *
     * @return ChatMessageStatusNotReadCountDto[]
     */
    public function getNotReadChatsCountByUserId(int $userId): array;
}
