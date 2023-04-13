<?php

namespace App\Services\ChatUser\Services;

use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\ChatUser\Repositories\ChatUserRepository;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserService implements ChatUserServiceContract
{
    public function __construct(private readonly ChatUserRepository $chatUserRepository)
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
}
