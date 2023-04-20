<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;

interface ChatUserChatInfoDtoFactoryContract
{
    /**
     * @param object $chatUser
     *
     * @return ChatUserChatInfoDto
     */
    public function createFromObject(object $chatUser): ChatUserChatInfoDto;
}
