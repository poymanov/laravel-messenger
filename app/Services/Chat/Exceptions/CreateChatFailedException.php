<?php

namespace App\Services\Chat\Exceptions;

use Exception;

class CreateChatFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create chat.';

        parent::__construct($message);
    }
}
