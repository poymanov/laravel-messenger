<?php

namespace App\Services\ChatUser\Factories;

use App\Services\ChatUser\Contracts\UserChatUserDtoFactoryContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class UserChatUserDtoFactory implements UserChatUserDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromObject(object $chatUser): UserChatUserDto
    {
        $dto           = new UserChatUserDto();
        $dto->chatId   = Uuid::make($chatUser->chat_id); // @phpstan-ignore-line
        $dto->userName = $chatUser->name; // @phpstan-ignore-line

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function createFromObjects(Collection $chatUsers): array
    {
        $dtos = [];

        foreach ($chatUsers as $chatUser) {
            $dtos[] = $this->createFromObject($chatUser);
        }

        return $dtos;
    }
}
