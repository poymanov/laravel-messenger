<?php

namespace App\Services\Chat\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class DeleteChatNotMemberException extends Exception
{
    public function __construct(Uuid $chatId, int $userId)
    {
        $message = "Failed to delete chat {$chatId->value()}. User {$userId} not member.";

        parent::__construct($message);
    }
}
