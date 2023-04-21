<?php

namespace App\Services\ChatUser\Formatters;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusNotReadCountDto;
use App\Services\ChatUser\Contracts\UserChatUserDtoFormatterContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;

class UserChatUserDtoFormatter implements UserChatUserDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(UserChatUserDto $dto): array
    {
        return [
            'chat_id'                 => $dto->chatId->value(),
            'username'                => $dto->userName,
            'avatar_url'              => $dto->avatarUrl,
            'last_message_text'       => $dto->lastMessageText,
            'last_message_created_at' => $dto->lastMessageCreatedAt?->getTimestamp(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos, array $notReadCounts): array
    {
        return array_map(function (UserChatUserDto $dto) use ($notReadCounts) {
            $chat             = $this->toArray($dto);
            $chat['not_read'] = 0;

            $chatCount = array_filter($notReadCounts, function (ChatMessageStatusNotReadCountDto $countDto) use ($dto) {
                return $countDto->chatId->equals($dto->chatId);
            });

            if (count($chatCount) > 0) {
                $chat['not_read'] = $chatCount[0]->count;
            }

            return $chat;
        }, $dtos);
    }
}
