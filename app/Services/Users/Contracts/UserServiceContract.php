<?php

namespace App\Services\Users\Contracts;

use App\Services\Users\Dtos\UserDto;

interface UserServiceContract
{
    /**
     * @param string $email
     *
     * @return UserDto[]
     */
    public function findAllBySimilarEmail(string $email): array;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function isExistsById(int $id): bool;
}
