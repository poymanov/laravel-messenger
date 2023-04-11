<?php

namespace Tests\Helpers\RouteBuilder;

class UserBuilder
{
    /**
     * @param string $email
     *
     * @return string
     */
    public function findAllBySimularEmail(string $email): string
    {
        return '/users/find-all-by-simular-email?email=' . $email;
    }
}
