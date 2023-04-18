<?php

namespace App\Services\ChatMessageStatus\Factories;

use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusCreateDtoFactoryContract;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageStatusCreateDtoFactory implements ChatMessageStatusCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(Uuid $chatId, Uuid $messageId, int $userId): ChatMessageStatusCreateDto
    {
        $dto = new ChatMessageStatusCreateDto();
        $dto->chatId = $chatId;
        $dto->messageId = $messageId;
        $dto->userId = $userId;

        return $dto;
    }
}
