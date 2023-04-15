<?php

namespace App\Services\ChatUser\Services;

use App\Services\ChatUser\Contracts\ChatUserRepositoryContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserService implements ChatUserServiceContract
{
    public function __construct(private readonly ChatUserRepositoryContract $chatUserRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, Uuid $chatId): void
    {
        $this->chatUserRepository->create($userId, $chatId);
    }

    /**
     * @inheritDoc
     */
    public function findChatIdByMemberIds(int $memberFirstId, int $memberSecondId): ?Uuid
    {
        return $this->chatUserRepository->findChatIdByMemberIds($memberFirstId, $memberSecondId);
    }

    /**
     * @inheritDoc
     */
    public function findAllChatIdsByUserId(int $userId): array
    {
        return $this->chatUserRepository->findAllChatIdsByUserId($userId);
    }

    /**
     * @inheritDoc
     */
    public function isChatMember(int $userId, Uuid $chatId): bool
    {
        return $this->chatUserRepository->isChatMember($userId, $chatId);
    }
}
