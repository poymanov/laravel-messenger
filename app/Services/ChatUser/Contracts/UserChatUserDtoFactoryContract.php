<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\UserChatUserDto;

interface UserChatUserDtoFactoryContract
{
    /**
     * @param object $chatUser
     *
     * @return UserChatUserDto
     */
    public function createFromObject(object $chatUser): UserChatUserDto;

    /**
     * @param array $chatUsers
     *
     * @return UserChatUserDto[]
     */
    public function createFromObjects(array $chatUsers): array;
}
