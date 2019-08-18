<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function testAuth(Request $request)
    {
        return response('',200);
    }
}
