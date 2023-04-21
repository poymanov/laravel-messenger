<?php

namespace App\Http\Middleware;

use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
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
        $chatStatusMessageService = app()->make(ChatMessageStatusServiceContract::class);

        if ($request->user()) {
            $userId         = (int)$request->user()->id;
            $chats          = $chatUserService->findAllChatsByUserId($userId);
            $notReadCounts  = $chatStatusMessageService->getNotReadChatsCountByUserId($userId);
            $chatsFormatted = $userChatUserDtoFormatter->fromArrayToArray($chats, $notReadCounts);
        } else {
            $chatsFormatted = [];
        }

        return array_merge(parent::share($request), [
            'auth'  => [
                'user'       => $request->user(),
                'avatar_url' => $request->user() ? $userAvatarService->getGravatarUrl($request->user()->email) : '',
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
