<?php

namespace App\Services\ChatUser\Dtos;

use DateTime;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class UserChatUserDto
{
    public Uuid $chatId;

    public string $userName;

    public string $avatarUrl;

    public ?string $lastMessageText;

    public ?DateTime $lastMessageCreatedAt;

    public bool $isOnline;
}
