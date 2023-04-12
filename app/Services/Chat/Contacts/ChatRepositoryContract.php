<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Exceptions\CreateChatFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatRepositoryContract
{
    /**
     * @return Uuid
     * @throws CreateChatFailedException
     */
    public function create(): Uuid;
}
