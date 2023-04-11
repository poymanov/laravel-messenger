<?php

namespace App\Services\Users\Formatters;

use App\Services\Users\Contracts\UserDtoFormatterContract;
use App\Services\Users\Dtos\UserDto;

class UserDtoFormatter implements UserDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(UserDto $dto): array
    {
        return [
            'id'    => $dto->id,
            'name'  => $dto->name,
            'email' => $dto->email,
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos): array
    {
        $result = [];

        foreach ($dtos as $dto) {
            $result[] = $this->toArray($dto);
        }

        return $result;
    }
}
