<?php

namespace App\Services\Users\Services;

use App\Services\Users\Contracts\UserRepositoryContract;
use App\Services\Users\Contracts\UserServiceContract;
use App\Services\Users\Contracts\UserUpdateOnlineStatusDtoFactoryContract;

class UserService implements UserServiceContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository,
        private readonly UserUpdateOnlineStatusDtoFactoryContract $userUpdateOnlineStatusDtoFactory
    ) {
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

    /**
     * @inheritDoc
     */
    public function updateOnlineStatus(int $id, bool $isOnline): void
    {
        $dto = $this->userUpdateOnlineStatusDtoFactory->createFromParams($id, $isOnline, now());

        $this->userRepository->updateOnlineStatus($dto);
    }

    /**
     * @inheritDoc
     */
    public function updateLastActivity(int $id): void
    {
        $this->userRepository->updateLastActivity($id, now());
    }
}
