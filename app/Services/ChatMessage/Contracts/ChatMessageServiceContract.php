<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;
use Throwable;

interface ChatMessageServiceContract
{
    /**
     * @param ChatMessageCreateDto $dto
     *
     * @return void
     * @throws ChatMessageChatNotFoundByIdException
     * @throws Throwable
     */
    public function create(ChatMessageCreateDto $dto): void;
}
