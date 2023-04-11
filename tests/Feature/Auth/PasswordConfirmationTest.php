<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('confirm password screen can be rendere', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(routeBuilderHelper()->auth->confirmPassword());

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
