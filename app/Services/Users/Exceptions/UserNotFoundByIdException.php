<?php

namespace App\Services\Users\Exceptions;

use Exception;

class UserNotFoundByIdException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'User not found by id: ' . $id;

        parent::__construct($message);
    }
}
