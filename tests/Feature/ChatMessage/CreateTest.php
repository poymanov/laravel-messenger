<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Попытка создания гостем
 */
test('guest', function () {
    $this->post(routeBuilderHelper()->chatMessage->create())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Попытка создания без данных
 */
test('empty', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chatMessage->create());
    $response->assertRedirect();
    $response->assertSessionHasErrors([
        'chat_id' => 'The chat id field is required.',
        'text'    => 'The text field is required.',
    ]);
});

/**
 * Попытка создания для несуществующего чата
 */
test('not existed chat', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chatMessage->create(), [
        'text'    => 'test',
        'chat_id' => fake()->uuid(),
    ]);
    $response->assertRedirect();
    $response->assertSessionHasErrors([
        'chat_id' => 'The selected chat id is invalid.',
    ]);
});

/**
 * Попытка создания сообщения для чата, в котором пользователь не состоит
 */
test('another users chat', function () {
    $chat = modelBuilderHelper()->chat->create();

    $this->actingAs(modelBuilderHelper()->user->create());

    $this->post(routeBuilderHelper()->chatMessage->create(), ['chat_id' => $chat->id, 'text' => 'test'])
        ->assertForbidden();
});

/**
 * Успешное создание сообщения
 */
test('success', function () {
    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $this->actingAs($userCreator);

    $text = fake()->sentence;

    $response = $this->post(routeBuilderHelper()->chatMessage->create(), ['chat_id' => $chat->id, 'text' => $text]);
    $response->assertSessionHasNoErrors();
    $response->assertNoContent();

    $this->assertDatabaseHas('chat_messages', [
        'chat_id' => $chat->id,
        'sender_user_id' => $userCreator->id,
        'text'    => $text,
    ]);
});
