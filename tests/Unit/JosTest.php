<?php

namespace Tests\Unit;

use App\Jos\JosProxy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JosTest extends TestCase
{
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
}
