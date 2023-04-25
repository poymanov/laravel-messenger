<?php

namespace App\Services\Users\Contracts;

use App\Services\Users\Dtos\UserDto;
use App\Services\Users\Exceptions\UserNotFoundByIdException;
use Throwable;

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

    /**
     * @param int  $id
     * @param bool $isOnline
     *
     * @return void
     */
    public function updateOnlineStatus(int $id, bool $isOnline): void;

    /**
     * @param int    $id
     *
     * @return void
     * @throws Throwable
     * @throws UserNotFoundByIdException
     */
    public function updateLastActivity(int $id): void;
}
