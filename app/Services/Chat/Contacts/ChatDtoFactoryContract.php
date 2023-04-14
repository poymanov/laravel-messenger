<?php

namespace App\Services\Chat\Contacts;

use App\Models\Chat;
use App\Services\Chat\Dtos\ChatDto;

interface ChatDtoFactoryContract
{
    /**
     * @param Chat $chat
     *
     * @return ChatDto
     */
    public function createFromModel(Chat $chat): ChatDto;
}
