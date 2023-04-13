<?php

namespace App\Services\ChatUser\Factories;

use App\Services\ChatUser\Contracts\UserChatUserDtoFactoryContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use stdClass;

class UserChatUserDtoFactory implements UserChatUserDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromObject(StdClass $chatUser): UserChatUserDto
    {
        $dto = new UserChatUserDto();
        $dto->chatId = Uuid::make($chatUser->chat_id);
        $dto->userName = $chatUser->name;

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
