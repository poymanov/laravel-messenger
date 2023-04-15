<?php

namespace App\Services\ChatUser\Contracts;

use App\Services\ChatUser\Dtos\UserChatUserDto;

interface UserChatUserDtoFormatterContract
{
    /**
     * @param UserChatUserDto $dto
     *
     * @return array
     */
    public function toArray(UserChatUserDto $dto): array;

    /**
     * @param UserChatUserDto[] $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;
}
