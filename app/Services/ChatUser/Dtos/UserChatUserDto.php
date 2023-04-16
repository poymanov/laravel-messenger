<?php

namespace App\Services\ChatUser\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class UserChatUserDto
{
    public Uuid $chatId;

    public string $userName;

    public string $avatarUrl;
}
