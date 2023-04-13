<?php

namespace App\Http\Middleware;

use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\ChatUser\Dtos\UserChatUserDto;
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
        $chatUserService = app()->make(ChatUserServiceContract::class);

        $chats = $request->user() ? $chatUserService->findAllChatIdsByUserId($request->user()->id) : [];

        $chats = array_map(function (UserChatUserDto $chat) {
            return [
                'chat_id' => $chat->chatId->value(),
                'username' => $chat->userName
            ];
        }, $chats);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'chats' => $chats
        ]);
    }
}
