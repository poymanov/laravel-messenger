<?php

namespace App\Services\ChatMessage\Formatters;

use App\Services\ChatMessage\Contracts\ChatMessageDtoFormatterContract;
use App\Services\ChatMessage\Dtos\ChatMessageDto;

class ChatMessageDtoFormatter implements ChatMessageDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(ChatMessageDto $dto): array
    {
        return [
            'id'             => $dto->id->value(),
            'chat_id'        => $dto->chatId->value(),
            'sender_user_id' => $dto->senderUserId,
            'text'           => $dto->text,
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos): array
    {
        return array_map(fn (ChatMessageDto $dto) => $this->toArray($dto), $dtos);
    }
}
