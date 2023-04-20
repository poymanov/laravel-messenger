<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;
use App\Services\ChatUser\Dtos\UserChatUserDto;
use App\Services\ChatUser\Exceptions\CreateUserFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatUserRepositoryContract
{
    /**
     * @param int $memberFirstId
     * @param int $memberSecondId
     *
     * @return Uuid|null
     */
    public function findChatIdByMemberIds(int $memberFirstId, int $memberSecondId): ?Uuid;

    /**
     * @param int  $userId
     * @param Uuid $chatId
     *
     * @return void
     * @throws CreateUserFailedException
     */
    public function create(int $userId, Uuid $chatId): void;

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
     * @return ChatUserChatInfoDto|null
     */
    public function findOneChatByChatIdAndUserId(Uuid $chatId, int $userId): ?ChatUserChatInfoDto;

    /**
     * @param int  $userId
     * @param Uuid $chatId
     *
     * @return bool
     */
    public function isChatMember(int $userId, Uuid $chatId): bool;

    /**
     * @param Uuid $chatId
     *
     * @return array
     */
    public function findChatMemberIds(Uuid $chatId): array;
}
