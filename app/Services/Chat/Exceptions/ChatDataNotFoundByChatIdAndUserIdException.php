<?php

namespace App\Services\Chat\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatDataNotFoundByChatIdAndUserIdException extends Exception
{
    public function __construct(Uuid $chatId, int $userId)
    {
        $message = "Chat data not found by chat id {$chatId->value()} and user id {$userId}";

        parent::__construct($message);
    }
}
