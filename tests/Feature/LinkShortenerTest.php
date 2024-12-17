<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('user can load dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/links');

    $response->assertOk();
});

test('user can create a link', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('links.store'), [
        'url' => 'https://example.com',
    ]);

    $this->assertDatabaseHas('links', [
        'url' => 'https://example.com',
    ]);
});

test('user can delete a link', function () {
    $user = User::factory()->create();
    $link = $user->links()->create([
        'url' => 'https://example.com',
    ]);

    $response = $this->actingAs($user)->delete('/links/'.$link->id);

    $this->assertDatabaseMissing('links', [
        'url' => 'https://example.com',
    ]);
});

test('user can open a short URL', function () {
    $user = User::factory()->create();
    $link = $user->links()->create([
        'url' => 'https://example.com',
    ]);

    $short_url = $link->short_url;

    $response = $this->get($short_url);

    $response->assertRedirect('https://example.com');
});

test('user cannot open an invalid short URL', function () {
    $response = $this->get('/l/invalid');

    $response->assertNotFound();
});

test('user can add an API key using sanctum and access the API', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $response = $this->get('/api/user');

    $response->assertOk();

});

test('user can encode a URL using the API', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $response = $this->post('/api/encode', [
        'url' => 'https://example.com',
    ]);

    $response->assertOk();
});

test('user can decode a short URL using the API', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $link = User::first()->links()->create([
        'url' => 'https://example.com',
    ]);

    $response = $this->post('/api/decode', [
        'short_url' => $link->short_url,
    ]);

    $response->assertOk();
});
