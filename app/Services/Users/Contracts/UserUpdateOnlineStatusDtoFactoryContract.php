<?php

namespace App\Services\Users\Contracts;

use App\Services\Users\Dtos\UserUpdateOnlineStatusDto;
use Illuminate\Support\Carbon;

interface UserUpdateOnlineStatusDtoFactoryContract
{
    /**
     * @param int    $userId
     * @param bool   $isOnline
     * @param Carbon $lastActivityAt
     *
     * @return UserUpdateOnlineStatusDto
     */
    public function createFromParams(int $userId, bool $isOnline, Carbon $lastActivityAt): UserUpdateOnlineStatusDto;
}
