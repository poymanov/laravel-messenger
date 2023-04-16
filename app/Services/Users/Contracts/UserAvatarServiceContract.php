<?php

namespace App\Services\Users\Contracts;

interface UserAvatarServiceContract
{
    /**
     * Получение ссылки на аватар пользователя
     *
     * @param string $email
     *
     * @return string
     */
    public function getGravatarUrl(string $email): string;
}
