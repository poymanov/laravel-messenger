<?php

namespace App\Services\Chat\Repositories;

use App\Models\Chat;
use App\Services\Chat\Contacts\ChatRepositoryContract;
use App\Services\Chat\Exceptions\CreateChatFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatRepository implements ChatRepositoryContract
{
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
}
