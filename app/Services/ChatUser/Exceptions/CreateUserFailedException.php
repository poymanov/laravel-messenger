<?php

namespace App\Services\ChatUser\Exceptions;

use Exception;

class CreateUserFailedException extends Exception
{
    public function __construct(int $userId, string $chatId)
    {
        $message = "Failed to create user {$userId} for chat {$chatId}";

        parent::__construct($message);
    }
}
