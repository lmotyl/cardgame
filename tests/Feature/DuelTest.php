<?php

it('Start New Duel', function () {
    authorize();
    $response = $this->post(route('duels.create'));

    $response->assertStatus(200);
});

test('Duel: add cards, start and pick one card', function() {
    authorize();
    $this->post(route('cards'));
    $this->post(route('cards'));
    $this->post(route('cards'));
    $this->post(route('cards'));
    $response = $this->post(route('cards'));
    $cards = $response->json();

    $this->post(route('duels.create'));

    $responseAction = $this->postJson(route('duels.action'), $cards[4]);
    $responseAction->assertStatus(200);

});
