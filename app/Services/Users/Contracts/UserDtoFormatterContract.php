<?php

namespace App\Services\Users\Contracts;

use App\Services\Users\Dtos\UserDto;

interface UserDtoFormatterContract
{
    /**
     * @param UserDto $dto
     *
     * @return array
     */
    public function toArray(UserDto $dto): array;

    /**
     * @param array $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;
}
