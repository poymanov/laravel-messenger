<?php

namespace App\Services\Users\Repositories;

use App\Models\User;
use App\Services\Users\Contracts\UserDtoFactoryContract;
use App\Services\Users\Contracts\UserRepositoryContract;
use App\Services\Users\Dtos\UserUpdateOnlineStatusDto;
use App\Services\Users\Exceptions\UserNotFoundByIdException;
use Illuminate\Support\Carbon;

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

    /**
     * @inheritDoc
     */
    public function isExistsById(int $id): bool
    {
        return User::whereId($id)->exists();
    }

    /**
     * @inheritDoc
     */
    public function updateOnlineStatus(UserUpdateOnlineStatusDto $dto): void
    {
        $model                   = $this->getOneModelById($dto->userId);
        $model->is_online        = $dto->isOnline;
        $model->last_activity_at = $dto->lastActivityAt;
        $model->saveOrFail();
    }

    /**
     * @inheritDoc
     */
    public function updateLastActivity(int $id, Carbon $date): void
    {
        $model                   = $this->getOneModelById($id);
        $model->last_activity_at = $date;
        $model->saveOrFail();
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundByIdException
     */
    private function getOneModelById(int $id): User
    {
        $model = User::whereId($id)->first();

        if (is_null($model)) {
            throw new UserNotFoundByIdException($id);
        }

        return $model;
    }
}
