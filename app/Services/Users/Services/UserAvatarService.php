<?php

namespace App\Services\Users\Services;

use App\Services\Users\Contracts\UserAvatarServiceContract;

class UserAvatarService implements UserAvatarServiceContract
{
    /**
     * @inheritDoc
     */
    public function getGravatarUrl(string $email): string
    {
        $hash = md5($email);

        return "https://gravatar.com/avatar/{$hash}?" . http_build_query(['s' => 60]);
    }
}
