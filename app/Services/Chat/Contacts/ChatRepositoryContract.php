<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\ChatDto;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\CreateChatFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

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

    /**
     * @param Uuid $id
     *
     * @return void
     * @throws ChatNotFoundByIdException
     * @throws Throwable
     */
    public function delete(Uuid $id);

    /**
     * @param Uuid $id
     *
     * @return bool
     */
    public function isExistsById(Uuid $id): bool;
}
