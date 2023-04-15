<?php

namespace App\Services\ChatMessage\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageDto
{
    public Uuid $id;

    public Uuid $chatId;

    public int $senderUserId;

    public string $text;
}
