<?php

use App\Events\Chat\NewMessageForUser;
use App\Events\Chat\NewMessageInChat;
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
    Event::fake();

    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $this->actingAs($userCreator);

    $text = fake()->sentence;

    $response = $this->post(routeBuilderHelper()->chatMessage->create(), ['chat_id' => $chat->id, 'text' => $text]);
    $response->assertSessionHasNoErrors();
    $response->assertOk();

    $message = $response->json();

    $this->assertEquals(now()->format('Y-m-d'), $message['date']);
    $this->assertEquals(now()->format('d F'), $message['title']);
    $this->assertEquals($chat->id, $message['message']['chat_id']);
    $this->assertEquals($userCreator->id, $message['message']['sender_user_id']);
    $this->assertEquals($text, $message['message']['text']);

    $this->assertDatabaseHas('chat_messages', [
        'chat_id'        => $chat->id,
        'sender_user_id' => $userCreator->id,
        'text'           => $text,
    ]);

    $this->assertDatabaseHas('chat_message_statuses', [
        'chat_id' => $chat->id,
        'user_id' => $userMember->id,
        'read_at' => null,
    ]);

    Event::dispatched(NewMessageInChat::class);
    Event::dispatched(NewMessageForUser::class);
});
