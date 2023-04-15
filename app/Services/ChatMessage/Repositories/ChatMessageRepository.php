<?php

namespace App\Services\ChatMessage\Repositories;

use App\Models\ChatMessage;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;

class ChatMessageRepository implements ChatMessageRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ChatMessageCreateDto $dto): void
    {
        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $dto->chatId->value();
        $chatMessage->sender_user_id = $dto->senderUserId;
        $chatMessage->text = $dto->text;
        $chatMessage->saveOrFail();
    }
}
