<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Попытка получения гостем
 */
test('guest', function () {
    $this->get(routeBuilderHelper()->user->findAllBySimularEmail('test'))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/**
 * Получение пользователя по частичному совпадению email
 */
test('partial match', function () {
    $user = modelBuilderHelper()->user->create(['email' => 'test@test.ru']);

    $this->actingAs($user);

    $response = $this->get(routeBuilderHelper()->user->findAllBySimularEmail('test'));
    $response->assertOk();

    $response->assertJson([
        [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ],
    ]);
});

/**
 * Получение пользователя по полному совпадению email
 */
test('full match', function () {
    $user = modelBuilderHelper()->user->create(['email' => 'test@test.ru']);

    $this->actingAs($user);

    $response = $this->get(routeBuilderHelper()->user->findAllBySimularEmail('test@test.ru'));
    $response->assertOk();

    $response->assertJson([
        [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ],
    ]);
});

/**
 * Получение нескольких пользователей
 */
test('several users', function () {
    $firstUser  = modelBuilderHelper()->user->create(['email' => 'test@test.ru']);
    $secondUser = modelBuilderHelper()->user->create(['email' => 'test2@test.ru']);

    $this->actingAs(modelBuilderHelper()->user->create());

    $response = $this->get(routeBuilderHelper()->user->findAllBySimularEmail('test'));
    $response->assertOk();

    $response->assertJson([
        [
            'id'    => $firstUser->id,
            'name'  => $firstUser->name,
            'email' => $firstUser->email,
        ],
        [
            'id'    => $secondUser->id,
            'name'  => $secondUser->name,
            'email' => $secondUser->email,
        ],
    ]);
});
