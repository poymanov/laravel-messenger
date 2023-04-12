<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Попытка создания гостем
 */
test('guest', function () {
    $this->post(routeBuilderHelper()->chat->create())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Попытка создания без данных
 */
test('empty', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chat->create());
    $response->assertRedirect();
    $response->assertSessionHasErrors(['user_id' => 'The user id field is required.']);
});

/**
 * Попытка создания для несуществующего пользователя
 */
test('not exists user', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->chat->create(), ['user_id' => 999]);
    $response->assertRedirect();
    $response->assertSessionHasErrors(['user_id' => 'The selected user id is invalid.']);
});

/**
 * Попытка создания с самим собой
 */
test('same user', function () {
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    $response = $this->post(routeBuilderHelper()->chat->create(), ['user_id' => $user->id]);
    $response->assertRedirect();
    $response->assertSessionHasErrors(['user_id' => 'The selected user id is invalid.']);
});

/**
 * Попытка создания уже существующего чата
 */
test('already exists', function () {
    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    $chat = modelBuilderHelper()->chat->create();
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    authHelper()->signIn($userCreator);

    $response = $this->post(routeBuilderHelper()->chat->create(), ['user_id' => $userMember->id]);
    $response->assertRedirect(routeBuilderHelper()->chat->show($chat->id));
    $response->assertSessionHasNoErrors();
});

/**
 * Успешное создание
 */
test('success', function () {
    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    authHelper()->signIn($userCreator);

    $response = $this->post(routeBuilderHelper()->chat->create(), ['user_id' => $userMember->id]);
    $response->assertRedirect();
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseCount('chats', 1);
    $this->assertDatabaseCount('chat_users', 2);

    $this->assertDatabaseHas('chat_users', [
        'user_id' => $userCreator->id,
    ]);

    $this->assertDatabaseHas('chat_users', [
        'user_id' => $userMember->id,
    ]);
});
