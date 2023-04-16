<?php

namespace App\Http\Middleware;

use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\ChatUser\Contracts\UserChatUserDtoFormatterContract;
use App\Services\Users\Contracts\UserAvatarServiceContract;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $chatUserService          = app()->make(ChatUserServiceContract::class);
        $userChatUserDtoFormatter = app()->make(UserChatUserDtoFormatterContract::class);
        $userAvatarService        = app()->make(UserAvatarServiceContract::class);

        if ($request->user()) {
            $chats          = $chatUserService->findAllChatsByUserId($request->user()->id);
            $chatsFormatted = $userChatUserDtoFormatter->fromArrayToArray($chats);
        } else {
            $chatsFormatted = [];
        }

        return array_merge(parent::share($request), [
            'auth'  => [
                'user' => $request->user(),
                'avatar_url' => $request->user() ? $userAvatarService->getGravatarUrl($request->user()->email) : ''
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'chats' => $chatsFormatted,
        ]);
    }
}
