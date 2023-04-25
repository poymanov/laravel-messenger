<?php

namespace App\Services\Users\Dtos;

use Illuminate\Support\Carbon;

class UserUpdateOnlineStatusDto
{
    public int $userId;

    public bool $isOnline;

    public Carbon $lastActivityAt;
}
