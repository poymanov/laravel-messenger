<?php

namespace App\Services\ChatUser\Formatters;

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
            'chat_id'  => $dto->chatId->value(),
            'username' => $dto->userName,
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos): array
    {
        return array_map(fn (UserChatUserDto $dto) => $this->toArray($dto), $dtos);
    }
}
