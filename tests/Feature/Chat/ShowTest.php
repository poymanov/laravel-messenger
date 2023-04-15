<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/**
 * Попытка просмотра гостем
 */
test('guest', function () {
    $chat = modelBuilderHelper()->chat->create();

    $this->get(routeBuilderHelper()->chat->show($chat->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Попытка просмотра несуществующего чата
 */
test('not existed', function () {
    $this->actingAs(modelBuilderHelper()->user->create());
    $this->get(routeBuilderHelper()->chat->show(fake()->uuid))
        ->assertRedirect(routeBuilderHelper()->common->home());
});

/**
 * Попытка просмотра чата, в котором пользователь не состоит
 */
test('another users chat', function () {
    $chat = modelBuilderHelper()->chat->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id]);

    $this->actingAs(modelBuilderHelper()->user->create());

    $this->get(routeBuilderHelper()->chat->show($chat->id))
        ->assertRedirect(routeBuilderHelper()->common->home());
});

/**
 * Успешный просмотр чата
 */
test('success', function () {
    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $this->actingAs($userCreator);

    $this->get(routeBuilderHelper()->chat->show($chat->id))->assertOk();
});

/**
 * Успешный просмотр чата с сообщениями
 */
test('success with messages', function () {
    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $messageFirst = modelBuilderHelper()->chatMessage->create(
        ['chat_id' => $chat->id, 'sender_user_id' => $userCreator->id, 'text' => fake()->sentence]
    );
    $this->travel(1)->hour();

    $messageSecond = modelBuilderHelper()->chatMessage->create(
        ['chat_id' => $chat->id, 'sender_user_id' => $userMember->id, 'text' => fake()->sentence]
    );

    $this->actingAs($userCreator);

    $response = $this->get(routeBuilderHelper()->chat->show($chat->id));
    $response->assertOk();

    $response
        ->assertInertia(
            fn (Assert $page) => $page->component('Chat/Show')
            ->has('messages', 2)
            ->has('messages.0', fn (Assert $page) => $page->whereAll([
                'id'             => $messageFirst->id,
                'chat_id'        => $messageFirst->chat_id,
                'sender_user_id' => $messageFirst->sender_user_id,
                'text'           => $messageFirst->text,
            ]))
            ->has('messages.1', fn (Assert $page) => $page->whereAll([
                'id'             => $messageSecond->id,
                'chat_id'        => $messageSecond->chat_id,
                'sender_user_id' => $messageSecond->sender_user_id,
                'text'           => $messageSecond->text,
            ]))
        );
});
