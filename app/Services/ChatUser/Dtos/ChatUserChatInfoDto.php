<?php

namespace App\Services\ChatUser\Dtos;

use Illuminate\Support\Carbon;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserChatInfoDto
{
    public Uuid $chatId;

    public string $userName;

    public string $avatarUrl;

    public string $email;

    public bool $isOnline;

    public ?Carbon $lastActivityAt;
}
