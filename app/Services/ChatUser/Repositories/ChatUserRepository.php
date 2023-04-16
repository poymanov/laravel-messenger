<?php

namespace App\Services\ChatUser\Repositories;

use App\Models\ChatUser;
use App\Services\ChatUser\Contracts\ChatUserRepositoryContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;
use App\Services\ChatUser\Exceptions\CreateUserFailedException;
use App\Services\ChatUser\Factories\UserChatUserDtoFactory;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserRepository implements ChatUserRepositoryContract
{
    public function __construct(private readonly UserChatUserDtoFactory $userChatUserDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, Uuid $chatId): void
    {
        $chatUser          = new ChatUser();
        $chatUser->user_id = $userId;
        $chatUser->chat_id = $chatId->value();

        if (!$chatUser->save()) {
            throw new CreateUserFailedException($userId, $chatId->value());
        }
    }

    /**
     * @inheritDoc
     */
    public function findChatIdByMemberIds(int $memberFirstId, int $memberSecondId): ?Uuid
    {
        $chatUser = DB::table('chat_users', 'cu1')
            ->join('chat_users as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->select('cu1.chat_id')
            ->where(['cu1.user_id' => $memberFirstId, 'cu2.user_id' => $memberSecondId])
            ->first();

        if ($chatUser) {
            return Uuid::make($chatUser->chat_id); // @phpstan-ignore-line
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function findAllChatsByUserId(int $userId): array
    {
        $chatUsers = DB::table('chat_users', 'cu1')
            ->join('chat_users as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->join('users as u', 'cu2.user_id', '=', 'u.id')
            ->select(['cu1.chat_id', 'u.name', 'u.email'])
            ->where(['cu1.user_id' => $userId])
            ->whereNot(['cu2.user_id' => $userId])
            ->get();

        return $this->userChatUserDtoFactory->createFromObjects($chatUsers);
    }

    /**
     * @param Uuid $chatId
     * @param int  $userId
     *
     * @return UserChatUserDto|null
     */
    public function findOneChatByChatIdAndUserId(Uuid $chatId, int $userId): ?UserChatUserDto
    {
        $chatUser = DB::table('chat_users', 'cu1')
            ->join('chat_users as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->join('users as u', 'cu2.user_id', '=', 'u.id')
            ->select(['cu1.chat_id', 'u.name', 'u.email'])
            ->where(['cu1.user_id' => $userId])
            ->whereNot(['cu2.user_id' => $userId])
            ->where(['cu1.chat_id' => $chatId->value()])
            ->first();

        if (is_null($chatUser)) {
            return null;
        }

        return $this->userChatUserDtoFactory->createFromObject($chatUser);
    }

    /**
     * @inheritDoc
     */
    public function isChatMember(int $userId, Uuid $chatId): bool
    {
        return ChatUser::whereChatId($chatId->value())->whereUserId($userId)->exists();
    }
}
