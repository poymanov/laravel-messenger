<?php

namespace App\Services\ChatUser\Factories;

use App\Services\ChatUser\Contracts\ChatUserChatInfoDtoFactoryContract;
use App\Services\ChatUser\Dtos\ChatUserChatInfoDto;
use App\Services\Users\Contracts\UserAvatarServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatUserChatInfoDtoFactory implements ChatUserChatInfoDtoFactoryContract
{
    public function __construct(private readonly UserAvatarServiceContract $userAvatarService)
    {
    }

    /**
     * @inheritDoc
     */
    public function createFromObject(object $chatUser): ChatUserChatInfoDto
    {
        $dto                       = new ChatUserChatInfoDto();
        $dto->chatId               = Uuid::make($chatUser->chat_id); // @phpstan-ignore-line
        $dto->userName             = $chatUser->name; // @phpstan-ignore-line
        $dto->avatarUrl            = $this->userAvatarService->getGravatarUrl($chatUser->email); // @phpstan-ignore-line

        return $dto;
    }
}
