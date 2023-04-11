<?php

namespace App\Http\Controllers;

use App\Services\Users\Contracts\UserDtoFormatterContract;
use App\Services\Users\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController
{
    public function __construct(
        private readonly UserServiceContract $userServiceContract,
        private readonly UserDtoFormatterContract $userDtoFormatter
    ) {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function findAllBySimularEmail(Request $request): JsonResponse
    {
        try {
            $users = $this->userServiceContract->findAllBySimilarEmail($request->get('email'));

            $usersFormatted = $this->userDtoFormatter->fromArrayToArray($users);

            return response()->json($usersFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
