<?php
uses(\Tests\TestCase::class)->in('Features');

it('User login', function () {
    $response = authorize();

    \PHPUnit\Framework\assertInstanceOf(\App\Models\User::class, $response);
});
