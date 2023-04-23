<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\ChatDto;
use App\Services\Chat\Dtos\CreateChatDto;
use App\Services\Chat\Dtos\DeleteChatDto;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\CreateChatUserNotFoundException;
use App\Services\Chat\Exceptions\DeleteChatNotMemberException;
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

    /**
     * @param DeleteChatDto $dto
     *
     * @return void
     * @throws ChatNotFoundByIdException
     * @throws DeleteChatNotMemberException
     */
    public function delete(DeleteChatDto $dto): void;

    /**
     * @param Uuid $id
     *
     * @return ChatDto
     * @throws ChatNotFoundByIdException
     */
    public function getById(Uuid $id): ChatDto;

    /**
     * @param Uuid  $chatId
     * @param array $chats
     *
     * @return array|null
     */
    public function getCurrentChatFromChats(Uuid $chatId, array $chats): ?array;

    /**
     * @param Uuid $id
     *
     * @return bool
     */
    public function isExistsById(Uuid $id): bool;
}
