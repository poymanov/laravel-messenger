<?php

namespace App\Services\ChatUser\Factories;

use App\Services\ChatUser\Contracts\UserChatUserDtoFactoryContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;
use App\Services\Users\Contracts\UserAvatarServiceContract;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class UserChatUserDtoFactory implements UserChatUserDtoFactoryContract
{
    public function __construct(private readonly UserAvatarServiceContract $userAvatarService)
    {
    }


    /**
     * @inheritDoc
     */
    public function createFromObject(object $chatUser): UserChatUserDto
    {
        $dto            = new UserChatUserDto();
        $dto->chatId    = Uuid::make($chatUser->chat_id); // @phpstan-ignore-line
        $dto->userName  = $chatUser->name; // @phpstan-ignore-line
        $dto->avatarUrl = $this->userAvatarService->getGravatarUrl($chatUser->email); // @phpstan-ignore-line

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
