<?php

namespace App\Services\Users\Factories;

use App\Services\Users\Contracts\UserUpdateOnlineStatusDtoFactoryContract;
use App\Services\Users\Dtos\UserUpdateOnlineStatusDto;
use Illuminate\Support\Carbon;

class UserUpdateOnlineStatusDtoFactory implements UserUpdateOnlineStatusDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(int $userId, bool $isOnline, Carbon $lastActivityAt): UserUpdateOnlineStatusDto
    {
        $dto                 = new UserUpdateOnlineStatusDto();
        $dto->userId         = $userId;
        $dto->isOnline       = $isOnline;
        $dto->lastActivityAt = $lastActivityAt;

        return $dto;
    }
}
