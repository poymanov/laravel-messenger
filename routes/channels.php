<?php

use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Illuminate\Support\Facades\Broadcast;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{id}', function ($user, $id) {
    $chatUserService = app()->make(ChatUserServiceContract::class);
    $chatId          = Uuid::make($id);

    return $chatUserService->isChatMember((int)$user->id, $chatId);
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int)$user->id === (int) $id;
});
