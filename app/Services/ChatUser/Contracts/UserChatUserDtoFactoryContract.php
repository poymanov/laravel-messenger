<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\UserChatUserDto;
use Illuminate\Support\Collection;

interface UserChatUserDtoFactoryContract
{
    /**
     * @param object $chatUser
     *
     * @return UserChatUserDto
     */
    public function createFromObject(object $chatUser): UserChatUserDto;

    /**
     * @param Collection $chatUsers
     *
     * @return UserChatUserDto[]
     */
    public function createFromObjects(Collection $chatUsers): array;
}
