<?php

namespace App\Services\ChatMessage\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageChatNotFoundByIdException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Chat not found by id: ' . $id->value();

        parent::__construct($message);
    }
}
