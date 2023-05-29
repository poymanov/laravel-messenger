<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Попытка сделать чат прочитанным гостем
 */
test('guest', function () {
    $this->post(routeBuilderHelper()->chatMessageStatus->makeChatRead())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Попытка сделать чат прочитанным без данных
 */
test('empty', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chatMessageStatus->makeChatRead());
    $response->assertRedirect();
    $response->assertSessionHasErrors([
        'chat_id' => 'The chat id field is required.'
    ]);
});

/**
 * Попытка сделать чат прочитанным для несуществующего чата
 */
test('not existed chat', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chatMessageStatus->makeChatRead(), [
        'chat_id' => fake()->uuid()
    ]);
    $response->assertRedirect();
    $response->assertSessionHasErrors([
        'chat_id' => 'The selected chat id is invalid.',
    ]);
});

/**
 * Попытка сделать прочитанным чат, в котором пользователь не состоит
 */
test('another users chat', function () {
    $chat = modelBuilderHelper()->chat->create();

    authHelper()->signIn();

    $this->post(routeBuilderHelper()->chatMessageStatus->makeChatRead(), ['chat_id' => $chat->id])
        ->assertForbidden();
});

/**
 * Успешная пометка сообщений чата прочитанными
 */
test('success', function () {
    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $messageText = fake()->sentence;

    $chatMessageFirst = modelBuilderHelper()->chatMessage->create(['chat_id' => $chat->id, 'sender_user_id' => $userMember->id, 'text' => $messageText]);
    $chatMessageSecond = modelBuilderHelper()->chatMessage->create(['chat_id' => $chat->id, 'sender_user_id' => $userMember->id, 'text' => $messageText]);

    $chatMessageStatusFirst = modelBuilderHelper()->chatMessageStatus->create(['chat_id' => $chat->id, 'message_id' => $chatMessageFirst->id, 'user_id' => $userCreator->id]);
    $chatMessageStatusSecond = modelBuilderHelper()->chatMessageStatus->create(['chat_id' => $chat->id, 'message_id' => $chatMessageSecond->id, 'user_id' => $userCreator->id]);

    $this->actingAs($userCreator);

    $response = $this->post(routeBuilderHelper()->chatMessageStatus->makeChatRead(), ['chat_id' => $chat->id]);
    $response->assertSessionHasNoErrors();
    $response->assertOk();

    $this->assertDatabaseMissing('chat_message_statuses', [
        'id' => $chatMessageStatusFirst->id,
        'read_at' => null,
    ]);

    $this->assertDatabaseMissing('chat_message_statuses', [
        'id' => $chatMessageStatusSecond->id,
        'read_at' => null,
    ]);
});
