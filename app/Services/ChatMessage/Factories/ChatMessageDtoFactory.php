<?php

namespace App\Services\ChatMessage\Factories;

use App\Models\ChatMessage;
use App\Services\ChatMessage\Contracts\ChatMessageDtoFactoryContract;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageDtoFactory implements ChatMessageDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(ChatMessage $chatMessage): ChatMessageDto
    {
        if (is_null($chatMessage->created_at)) {
            throw new Exception('Chat message without date created: ' . $chatMessage->id);
        }

        $dto               = new ChatMessageDto();
        $dto->id           = Uuid::make($chatMessage->id);
        $dto->chatId       = Uuid::make($chatMessage->chat_id);
        $dto->senderUserId = $chatMessage->sender_user_id;
        $dto->text         = $chatMessage->text;
        $dto->createdAt    = $chatMessage->created_at;

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function createFromModels(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = $this->createFromModel($model);
        }

        return $dtos;
    }
}
