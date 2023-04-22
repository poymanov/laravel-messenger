<?php

namespace App\Services\ChatMessageStatus\Services;

use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusRepositoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageStatusService implements ChatMessageStatusServiceContract
{
    public function __construct(private readonly ChatMessageStatusRepositoryContract $chatMessageStatusRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(ChatMessageStatusCreateDto $dto): void
    {
        $this->chatMessageStatusRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function getNotReadChatsCountByUserId(int $userId): array
    {
        return $this->chatMessageStatusRepository->getNotReadChatsCountByUserId($userId);
    }

    /**
     * @inheritDoc
     */
    public function makeReadByChatIdAndUserId(Uuid $chatId, int $userId): void
    {
        $this->chatMessageStatusRepository->makeReadByChatIdAndUserId($chatId, $userId);
    }
}
