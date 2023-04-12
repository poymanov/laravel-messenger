<?php

namespace App\Services\Chat\Exceptions;

use Exception;

class CreateChatUserNotFoundException extends Exception
{
    public function __construct(int $userId)
    {
        $message = 'Create chat: user not found: ' . $userId;

        parent::__construct($message);
    }
}
