<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
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

    /**
     * @param Uuid $chatId
     *
     * @return ChatMessageDto[]
     */
    public function findAllByChatId(Uuid $chatId): array;
}
