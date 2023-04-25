<?php

namespace App\Http\Middleware;

use App\Services\Users\Contracts\UserServiceContract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserActivity
{
    public function __construct(private readonly UserServiceContract $userService)
    {
    }


    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $this->userService->updateLastActivity($this->getAuthUserId($request));
        }

        return $next($request);
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getAuthUserId(Request $request): int
    {
        if (is_null($request->user())) {
            throw new BadRequestHttpException('Auth user not found');
        }

        return $request->user()->id;
    }
}
