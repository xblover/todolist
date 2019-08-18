<?php

namespace Tests\Unit;

use App\Jos\JosProxy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Token;

class JosTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function verify_jos_proxy()
    {
        $params = [
            'app_key' => 'app_keyapp_key',
            'v' => 'v',
            'method' => 'method',
            'timestamp' => 'timestamp',
            'access_token' => 'access_token',
            '360buy_param_json' => '360buy_param_json',
            'sign' => 'sign',
        ];
        $return = (object)[
            'jos_proxy' => 'ok'
        ];

        $this->mock(JosProxy::class, function ($mock) use($params, $return){
            /** @var Mock $mock */
            $mock->shouldReceive('send')->with($params)->once()->andReturn($return);
        });

        $response = $this->withoutExceptionHandling()->post('api/jos-proxy', $params);
        $this->assertSame(json_encode($return), $response->getContent());
    }

    /** @test */
//    public function verify_get_order_by_id_when_local_do_not_have_order()
//    {
//
//
//        $response = $this->visitProtectedRoute($token,$id);
//        $this->assertSame(json_encode($return),$response->getContent());
////        $response = $this->withoutExceptionHandling()->get("api/orders/{$id}");
//    }
    /** @test */
    public function fetch_order_successful_when_local_has_one_order()
    {

        $response = $this->visitOrderFetchApi();

        $this->assertGreaterThanOrEqual($beforeTime, $orderInDB->fetched_at);
    }

    protected function createTokenWithinFiveMinutes(string $token): Token
    {
        $data = [
            'access_token' => $token,
            'md5_access_token' => md5($token),
            'checked_at' => Carbon::now()->addMinutes(-1)
        ];
        return Token::create($data);
    }

    protected function visitOrderFetchApi(): TestResponse
    {
        $this->createTokenWithinFiveMinutes($token = 'test');
        $response = $this->withoutExceptionHandling()->withHeader('Authorization',
            'Bearer ' . $token)->get('api/orders/fetch');
        return $response;
    }

    protected function visitProtectedRoute(string $token, string $id): TestResponse
    {
        $response = $this->withoutExceptionHandling()->withHeader('Authorization',
            'Bearer ' . $token)->get("api/orders/{$id}");
        return $response;
    }
}
