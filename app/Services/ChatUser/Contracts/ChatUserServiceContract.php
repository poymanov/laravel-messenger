<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\UserChatUserDto;
use App\Services\ChatUser\Exceptions\CreateUserFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatUserServiceContract
{
    /**
     * @param int  $userId
     * @param Uuid $chatId
     *
     * @return void
     * @throws CreateUserFailedException
     */
    public function create(int $userId, Uuid $chatId): void;

    /**
     * @param int $memberFirstId
     * @param int $memberSecondId
     *
     * @return Uuid|null
     */
    public function findChatIdByMemberIds(int $memberFirstId, int $memberSecondId): ?Uuid;

    /**
     * @param int $userId
     *
     * @return UserChatUserDto[]
     */
    public function findAllChatsByUserId(int $userId): array;

    /**
     * @param Uuid $chatId
     * @param int  $userId
     *
     * @return UserChatUserDto|null
     */
    public function findOneChatByChatIdAndUserId(Uuid $chatId, int $userId): ?UserChatUserDto;

    /**
     * @param int  $userId
     * @param Uuid $chatId
     *
     * @return bool
     */
    public function isChatMember(int $userId, Uuid $chatId): bool;
}
