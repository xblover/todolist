<?php


namespace Tests\Integration;


use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenManagerRemoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function route_is_not_authed_when_token_cannot_be_verified()
    {
        $token = 'testtest';

        $response = $this->withoutExceptionHandling()->withHeader('Authorization', 'Bearer ' . $token)->json('POST', route('auth'));

        $response->assertStatus(401);
    }

}
