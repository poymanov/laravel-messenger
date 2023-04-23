<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Попытка удаления гостем
 */
test('guest', function () {
    $this->delete(routeBuilderHelper()->chat->delete(1))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Попытка удаления несуществующего чата
 */
test('not exists chat', function () {
    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->chat->delete(fake()->uuid));
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

/**
 * Попытка удаления чата, в котором пользователь не состоит
 */
test('not chat member', function () {
    authHelper()->signIn();

    $chat = modelBuilderHelper()->chat->create();

    $response = $this->delete(routeBuilderHelper()->chat->delete($chat->id));
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

/**
 * Успешное удаление чата
 */
test('success', function () {
    $firstUser  = modelBuilderHelper()->user->create();
    $secondUser = modelBuilderHelper()->user->create();

    $chat = modelBuilderHelper()->chat->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $firstUser->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $secondUser->id]);

    $message = modelBuilderHelper()->chatMessage->create(['chat_id' => $chat->id, 'sender_user_id' => $firstUser->id, 'text' => 'test']);

    modelBuilderHelper()->chatMessageStatus->create(
        ['chat_id' => $chat->id, 'message_id' => $message->id, 'user_id' => $secondUser->id]
    );

    authHelper()->signIn($firstUser);

    $response = $this->delete(routeBuilderHelper()->chat->delete($chat->id));
    $response->assertRedirect(routeBuilderHelper()->common->home());

    $this->assertDatabaseEmpty('chats');
    $this->assertDatabaseEmpty('chat_users');
    $this->assertDatabaseEmpty('chat_messages');
    $this->assertDatabaseEmpty('chat_message_statuses');
});
