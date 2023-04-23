<?php

namespace App\Services\Chat\Factories;

use App\Services\Chat\Contacts\DeleteChatDtoFactoryContract;
use App\Services\Chat\Dtos\DeleteChatDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class DeleteChatDtoFactory implements DeleteChatDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(Uuid $chatId, int $userId): DeleteChatDto
    {
        $dto = new DeleteChatDto();
        $dto->chatId = $chatId;
        $dto->userId = $userId;

        return $dto;
    }
}
