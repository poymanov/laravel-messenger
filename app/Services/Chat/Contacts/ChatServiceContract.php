<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\CreateChatDto;
use App\Services\Chat\Exceptions\CreateChatUserNotFoundException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatServiceContract
{
    /**
     * @param CreateChatDto $createChatDto
     *
     * @return Uuid
     * @throws CreateChatUserNotFoundException
     */
    public function create(CreateChatDto $createChatDto): Uuid;
}
