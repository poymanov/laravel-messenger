<?php

namespace App\Services\Chat\Factories;

use App\Services\Chat\Contacts\CreateChatDtoFactoryContract;
use App\Services\Chat\Dtos\CreateChatDto;

class CreateChatDtoFactory implements CreateChatDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(int $creatorId, int $memberId): CreateChatDto
    {
        $dto          = new CreateChatDto();
        $dto->creatorId = $creatorId;
        $dto->memberId  = $memberId;

        return $dto;
    }
}
