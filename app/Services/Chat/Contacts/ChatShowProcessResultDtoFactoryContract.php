<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\ChatShowProcessResultDto;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;

interface ChatShowProcessResultDtoFactoryContract
{
    /**
     * @param ChatUserChatInfoDto $chatData
     * @param ChatMessageDto[]    $messages
     *
     * @return ChatShowProcessResultDto
     */
    public function createFromData(ChatUserChatInfoDto $chatData, array $messages): ChatShowProcessResultDto;
}
