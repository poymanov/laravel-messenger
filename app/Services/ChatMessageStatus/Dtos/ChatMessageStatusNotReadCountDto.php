<?php

namespace App\Services\ChatMessageStatus\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageStatusNotReadCountDto
{
    public Uuid $chatId;

    public int $count;
}
