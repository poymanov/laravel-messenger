<?php

namespace App\Services\Chat\Repositories;

use App\Models\Chat;
use App\Services\Chat\Contacts\ChatDtoFactoryContract;
use App\Services\Chat\Contacts\ChatRepositoryContract;
use App\Services\Chat\Dtos\ChatDto;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\CreateChatFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatRepository implements ChatRepositoryContract
{
    public function __construct(private readonly ChatDtoFactoryContract $chatDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(): Uuid
    {
        $chat = new Chat();

        if (!$chat->save()) {
            throw new CreateChatFailedException();
        }

        $chat->refresh();

        return Uuid::make($chat->id);
    }

    /**
     * @inheritDoc
     */
    public function getById(Uuid $id): ChatDto
    {
        $chat = Chat::whereId($id->value())->first();

        if (is_null($chat)) {
            throw new ChatNotFoundByIdException($id);
        }

        return $this->chatDtoFactory->createFromModel($chat);
    }

    /**
     * @inheritDoc
     */
    public function isExistsById(Uuid $id): bool
    {
        return Chat::whereId($id->value())->exists();
    }
}
