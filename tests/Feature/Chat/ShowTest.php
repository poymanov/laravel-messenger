<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

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
