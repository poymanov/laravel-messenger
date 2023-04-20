<?php

namespace App\Services\ChatUser\Repositories;

use App\Models\ChatUser;
use App\Services\ChatUser\Contracts\ChatUserChatInfoDtoFactoryContract;
use App\Services\ChatUser\Contracts\ChatUserRepositoryContract;
use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;
use App\Services\ChatUser\Exceptions\CreateUserFailedException;
use App\Services\ChatUser\Factories\UserChatUserDtoFactory;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserRepository implements ChatUserRepositoryContract
{
    public function __construct(
        private readonly UserChatUserDtoFactory $userChatUserDtoFactory,
        private readonly ChatUserChatInfoDtoFactoryContract $chatUserChatInfoDtoFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, Uuid $chatId): void
    {
        $chatUser = new ChatUser();
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
        $chatUsers = DB::select(
            'SELECT cu1.chat_id, u.name, u.email, cm.text as last_message_text, cm.created_at as last_message_created_at
FROM chat_users cu1
JOIN chat_users as cu2 ON cu1.chat_id = cu2.chat_id
JOIN users as u ON cu2.user_id = u.id
LEFT JOIN chat_messages as cm ON cu1.chat_id = cm.chat_id AND cm.id = (SELECT id from chat_messages cm2 WHERE cm2.chat_id = cu1.chat_id ORDER BY cm2.created_at DESC LIMIT 1)
WHERE cu1.user_id = :user_id AND cu2.user_id <> :user_id
ORDER BY cm.created_at DESC',
            ['user_id' => $userId]
        );

        return $this->userChatUserDtoFactory->createFromObjects($chatUsers);
    }

    /**
     * @inheritDoc
     */
    public function findOneChatByChatIdAndUserId(Uuid $chatId, int $userId): ?ChatUserChatInfoDto
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

        return $this->chatUserChatInfoDtoFactory->createFromObject($chatUser);
    }

    /**
     * @inheritDoc
     */
    public function isChatMember(int $userId, Uuid $chatId): bool
    {
        return ChatUser::whereChatId($chatId->value())->whereUserId($userId)->exists();
    }

    /**
     * @inheritDoc
     */
    public function findChatMemberIds(Uuid $chatId): array
    {
        return ChatUser::whereChatId($chatId->value())->select('user_id')->get()->pluck('user_id')->toArray();
    }
}
