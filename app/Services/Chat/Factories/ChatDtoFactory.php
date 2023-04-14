<?php

namespace App\Services\Chat\Factories;

use App\Models\Chat;
use App\Services\Chat\Contacts\ChatDtoFactoryContract;
use App\Services\Chat\Dtos\ChatDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatDtoFactory implements ChatDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(Chat $chat): ChatDto
    {
        $dto = new ChatDto();
        $dto->id = Uuid::make($chat->id);

        return $dto;
    }
}
