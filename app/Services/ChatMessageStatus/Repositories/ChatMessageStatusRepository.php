<?php

namespace App\Services\ChatMessageStatus\Repositories;

use App\Models\ChatMessageStatus;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusRepositoryContract;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;

class ChatMessageStatusRepository implements ChatMessageStatusRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ChatMessageStatusCreateDto $dto): void
    {
        $model             = new ChatMessageStatus();
        $model->chat_id    = $dto->chatId->value();
        $model->message_id = $dto->messageId->value();
        $model->user_id    = $dto->userId;
        $model->saveOrFail();
    }
}
