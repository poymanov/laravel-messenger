<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirect to login screen', function () {
    $response = $this->followingRedirects()->get(routeBuilderHelper()->common->home());

    $response->assertStatus(200);
});

it('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

it('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
