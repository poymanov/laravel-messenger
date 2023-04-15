<?php

namespace App\Services\ChatMessage\Factories;

use App\Models\ChatMessage;
use App\Services\ChatMessage\Contracts\ChatMessageDtoFactoryContract;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use Illuminate\Database\Eloquent\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageDtoFactory implements ChatMessageDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(ChatMessage $chatMessage): ChatMessageDto
    {
        $dto               = new ChatMessageDto();
        $dto->id           = Uuid::make($chatMessage->id);
        $dto->chatId       = Uuid::make($chatMessage->chat_id);
        $dto->senderUserId = $chatMessage->sender_user_id;
        $dto->text         = $chatMessage->text;

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
