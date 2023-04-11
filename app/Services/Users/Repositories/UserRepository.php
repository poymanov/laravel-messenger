<?php

namespace App\Services\Users\Repositories;

use App\Models\User;
use App\Services\Users\Contracts\UserDtoFactoryContract;
use App\Services\Users\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    public function __construct(private readonly UserDtoFactoryContract $userDtoFactoryContract)
    {
    }

    /**
     * @inheritDoc
     */
    public function findAllBySimilarEmail(string $email): array
    {
        $users = User::where('email', 'LIKE', '%' . $email . '%')
            ->orderByDesc('email')
            ->get();

        return $this->userDtoFactoryContract->createFromModels($users);
    }
}
