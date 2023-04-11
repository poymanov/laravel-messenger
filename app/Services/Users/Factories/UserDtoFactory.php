<?php

namespace App\Services\Users\Factories;

use App\Models\User;
use App\Services\Users\Contracts\UserDtoFactoryContract;
use App\Services\Users\Dtos\UserDto;
use Illuminate\Database\Eloquent\Collection;

class UserDtoFactory implements UserDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(User $user): UserDto
    {
        $userDto        = new UserDto();
        $userDto->id    = $user->id;
        $userDto->name  = $user->name;
        $userDto->email = $user->email;


        return $userDto;
    }

    /**
     * @inheritDoc
     */
    public function createFromModels(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = $this->createFromModel($model);
        }

        return $dtos;
    }
}
