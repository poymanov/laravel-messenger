<?php

namespace App\Services\Users\Contracts;

use App\Models\User;
use App\Services\Users\Dtos\UserDto;
use Illuminate\Database\Eloquent\Collection;

interface UserDtoFactoryContract
{
    /**
     * @param User $user
     *
     * @return UserDto
     */
    public function createFromModel(User $user): UserDto;

    /**
     * @param Collection $models
     *
     * @return UserDto[]
     */
    public function createFromModels(Collection $models): array;
}
