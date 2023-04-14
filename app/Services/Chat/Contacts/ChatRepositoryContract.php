<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\ChatDto;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\CreateChatFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatRepositoryContract
{
    /**
     * @return Uuid
     * @throws CreateChatFailedException
     */
    public function create(): Uuid;

    /**
     * @param Uuid $id
     *
     * @return ChatDto
     * @throws ChatNotFoundByIdException
     */
    public function getById(Uuid $id): ChatDto;
}
