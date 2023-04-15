<?php

namespace App\Services\ChatMessage\Factories;

use App\Services\ChatMessage\Contracts\ChatMessageCreateDtoFactoryContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageCreateDtoFactory implements ChatMessageCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(int $senderUserId, Uuid $chatId, string $text): ChatMessageCreateDto
    {
        $dto = new ChatMessageCreateDto();
        $dto->senderUserId = $senderUserId;
        $dto->chatId = $chatId;
        $dto->text = $text;

        return $dto;
    }
}
