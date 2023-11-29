<?php

it('Pick Cards', function () {
    $user = authorize();
    $response = $this->post(route('cards'));
    $response->assertStatus(200)
    ->assertJsonStructure([["id", "name", "power", "image"]]);

    $json = $response->json();

    $userCards = \App\Models\UserCards::where('user_id', $user->id)->get();
    $this->assertEquals($json[0]['id'], $userCards[0]['card_id']);
});
