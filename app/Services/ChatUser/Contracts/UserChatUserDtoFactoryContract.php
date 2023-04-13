<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\UserChatUserDto;
use Illuminate\Support\Collection;
use stdClass;

interface UserChatUserDtoFactoryContract
{
    /**
     * @param stdClass $chatUser
     *
     * @return UserChatUserDto
     */
    public function createFromObject(StdClass $chatUser): UserChatUserDto;

    /**
     * @param Collection $chatUsers
     *
     * @return UserChatUserDto[]
     */
    public function createFromObjects(Collection $chatUsers): array;
}
