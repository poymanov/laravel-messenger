<?php

namespace App\Services\ChatMessage\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageCreateDto
{
    public int $senderUserId;

    public Uuid $chatId;

    public string $text;
}
