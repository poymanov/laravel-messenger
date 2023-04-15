<?php

namespace App\Services\ChatMessage\Services;

use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

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
    public function create(ChatMessageCreateDto $dto): Uuid
    {
        if (!$this->chatService->isExistsById($dto->chatId)) {
            throw new ChatMessageChatNotFoundByIdException($dto->chatId);
        }

        return $this->chatMessageRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function findAllByChatId(Uuid $chatId): array
    {
        return $this->chatMessageRepository->findAllByChatId($chatId);
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): ChatMessageDto
    {
        return $this->chatMessageRepository->getOneById($id);
    }
}
