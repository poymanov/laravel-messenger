<?php

namespace App\Services\ChatMessage\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageNotFoundByIdException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Chat message not found by id: ' . $id->value();

        parent::__construct($message);
    }
}
