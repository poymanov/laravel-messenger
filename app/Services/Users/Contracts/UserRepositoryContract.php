<?php

namespace App\Services\Users\Contracts;

use App\Services\Users\Dtos\UserDto;
use App\Services\Users\Dtos\UserUpdateOnlineStatusDto;
use App\Services\Users\Exceptions\UserNotFoundByIdException;
use Illuminate\Support\Carbon;
use Throwable;

interface UserRepositoryContract
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
     * @param UserUpdateOnlineStatusDto $dto
     *
     * @return void
     * @throws UserNotFoundByIdException
     * @throws Throwable
     */
    public function updateOnlineStatus(UserUpdateOnlineStatusDto $dto): void;

    /**
     * @param int    $id
     * @param Carbon $date
     *
     * @return void
     * @throws Throwable
     * @throws UserNotFoundByIdException
     */
    public function updateLastActivity(int $id, Carbon $date): void;
}
