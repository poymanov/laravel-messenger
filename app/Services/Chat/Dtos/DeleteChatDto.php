<?php

namespace App\Services\Chat\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class DeleteChatDto
{
    public Uuid $chatId;

    public int $userId;
}
