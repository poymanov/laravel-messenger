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
 * Успешный просмотр чата с сообщениями в один день
 */
test('success with messages in same day', function () {
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
                ->has('messages.' . $messageFirst->created_at->format('Y-m-d'), fn (Assert $page) => $page->whereAll([
                    'title'    => $messageFirst->created_at->format('d F'),
                    'messages' => [
                        [
                            'id'              => $messageFirst->id,
                            'chat_id'         => $messageFirst->chat_id,
                            'sender_user_id'  => $messageFirst->sender_user_id,
                            'text'            => $messageFirst->text,
                            'created_at'      => $messageFirst->created_at->format('Y-m-d H:i:s'),
                            'created_at_time' => $messageFirst->created_at->format('H:i'),
                        ],
                        [
                            'id'              => $messageSecond->id,
                            'chat_id'         => $messageSecond->chat_id,
                            'sender_user_id'  => $messageSecond->sender_user_id,
                            'text'            => $messageSecond->text,
                            'created_at'      => $messageSecond->created_at->format('Y-m-d H:i:s'),
                            'created_at_time' => $messageSecond->created_at->format('H:i'),
                        ],
                    ],
                ]))
        );
});

/**
 * Успешный просмотр чата с сообщениями в разные дни
 */
test('success with messages in different days', function () {
    $chat = modelBuilderHelper()->chat->create();

    $userCreator = modelBuilderHelper()->user->create();
    $userMember  = modelBuilderHelper()->user->create();

    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userCreator->id]);
    $this->travel(1)->day();
    modelBuilderHelper()->chatUser->create(['chat_id' => $chat->id, 'user_id' => $userMember->id]);

    $messageFirst = modelBuilderHelper()->chatMessage->create(
        ['chat_id' => $chat->id, 'sender_user_id' => $userCreator->id, 'text' => fake()->sentence]
    );
    $this->travel(1)->day();

    $messageSecond = modelBuilderHelper()->chatMessage->create(
        ['chat_id' => $chat->id, 'sender_user_id' => $userMember->id, 'text' => fake()->sentence]
    );

    $this->actingAs($userCreator);

    $response = $this->get(routeBuilderHelper()->chat->show($chat->id));
    $response->assertOk();

    $response
        ->assertInertia(
            fn (Assert $page) => $page->component('Chat/Show')
                ->has('messages.' . $messageFirst->created_at->format('Y-m-d'), fn (Assert $page) => $page->whereAll([
                    'title'    => $messageFirst->created_at->format('d F'),
                    'messages' => [
                        [
                            'id'              => $messageFirst->id,
                            'chat_id'         => $messageFirst->chat_id,
                            'sender_user_id'  => $messageFirst->sender_user_id,
                            'text'            => $messageFirst->text,
                            'created_at'      => $messageFirst->created_at->format('Y-m-d H:i:s'),
                            'created_at_time' => $messageFirst->created_at->format('H:i'),
                        ],
                    ],
                ]))
                ->has('messages.' . $messageSecond->created_at->format('Y-m-d'), fn (Assert $page) => $page->whereAll([
                    'title'    => $messageSecond->created_at->format('d F'),
                    'messages' => [
                        [
                            'id'              => $messageSecond->id,
                            'chat_id'         => $messageSecond->chat_id,
                            'sender_user_id'  => $messageSecond->sender_user_id,
                            'text'            => $messageSecond->text,
                            'created_at'      => $messageSecond->created_at->format('Y-m-d H:i:s'),
                            'created_at_time' => $messageSecond->created_at->format('H:i'),
                        ],
                    ],
                ]))
        );
});
