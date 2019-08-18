<?php

namespace Tests\Unit;

use App\Token;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_is_not_checked_within_five_minutes_when_checked_at_is_empty()
    {
        $token = new Token();

        $this->assertFalse($token->checkedWithinFiveMinutes());
    }

    /** @test */
    public function when_checked_at_over_five_minutes()
    {
        $token = new Token();
        $token->checked_at = Carbon::now()->addMinutes(-6);

        $this->assertFalse($token->checkedWithinFiveMinutes());

    }

    /** @test */
    public function when_checked_at_within_five_minutes()
    {
        $token = new Token();
        $token->checked_at = Carbon::now()->addMinutes(-1);

        $this->assertFalse($token->checkedWithinFiveMinutes());

    }

}
