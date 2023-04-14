<?php

namespace App\Services\Chat\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatNotFoundByIdException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Chat not found by id: ' . $id->value();

        parent::__construct($message);
    }
}
