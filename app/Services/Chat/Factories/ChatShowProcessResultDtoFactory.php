<?php

namespace App\Services\Chat\Factories;

use App\Services\Chat\Contacts\ChatShowProcessResultDtoFactoryContract;
use App\Services\Chat\Dtos\ChatShowProcessResultDto;
use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;

class ChatShowProcessResultDtoFactory implements ChatShowProcessResultDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromData(ChatUserChatInfoDto $chatData, array $messages): ChatShowProcessResultDto
    {
        $dto = new ChatShowProcessResultDto();
        $dto->chatData = $chatData;
        $dto->messages = $messages;

        return $dto;
    }
}
