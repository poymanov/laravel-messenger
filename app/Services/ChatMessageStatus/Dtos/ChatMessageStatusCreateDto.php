<?php

namespace App\Services\ChatMessageStatus\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageStatusCreateDto
{
    public Uuid $chatId;

    public Uuid $messageId;

    public int $userId;
}
