<?php

namespace App\Services\Users\Services;

use App\Services\Users\Contracts\UserRepositoryContract;
use App\Services\Users\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    public function __construct(private readonly UserRepositoryContract $userRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function findAllBySimilarEmail(string $email): array
    {
        return $this->userRepository->findAllBySimilarEmail($email);
    }

    /**
     * @inheritDoc
     */
    public function isExistsById(int $id): bool
    {
        return $this->userRepository->isExistsById($id);
    }
}
