<?php


namespace App\Http\Controllers\Api;


use App\Jos\JosProxy;
use \Illuminate\Http\Request;

class JosController
{
    public function josProxy(Request $request)
    {
        $params = [];
        $params['app_key'] = $request->get('app_key');
        $params['v'] = $request->get('v');
        $params['method'] = $request->get('method');
        $params['timestamp'] = $request->get('timestamp');
        $params['access_token'] = $request->get('access_token');
        $params['360buy_param_json'] = $request->get('360buy_param_json');
        $params['sign'] = $request->get('sign');

        return json_encode(app(JosProxy::class)->send($params));
    }

    public function fetchOrder()
    {

    }
}
