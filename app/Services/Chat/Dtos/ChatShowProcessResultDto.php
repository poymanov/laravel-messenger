<?php

namespace App\Services\Chat\Dtos;

use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;

class ChatShowProcessResultDto
{
    public ChatUserChatInfoDto $chatData;

    /** @var ChatMessageDto[] */
    public array $messages;
}
