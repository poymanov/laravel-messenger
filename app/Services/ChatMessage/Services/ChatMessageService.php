<?php

namespace App\Services\ChatMessage\Services;

use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;

class ChatMessageService implements ChatMessageServiceContract
{
    public function __construct(
        private readonly ChatServiceContract $chatService,
        private readonly ChatMessageRepositoryContract $chatMessageRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(ChatMessageCreateDto $dto): void
    {
        if (!$this->chatService->isExistsById($dto->chatId)) {
            throw new ChatMessageChatNotFoundByIdException($dto->chatId);
        }

        $this->chatMessageRepository->create($dto);
    }
}
