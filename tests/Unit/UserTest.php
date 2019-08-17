<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_register()
    {
       $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
        ];
        $old = User::where('email' , 'test@gmail.com')->count();
        
        $response = $this->withoutExceptionHandling()->json('POST',route('register'),$data);
        $response->assertStatus(200);
        $new = User::where('email' , 'test@gmail.com')->count();
        $this->assertEquals(1,$new-$old);
        
        User::where('email','test@gmail.com')->delete();
    }

    /** @test */
    public function test_login()
    {
    
       User::create([
           'name' => 'test',
           'email' => 'test@gmail.com',
           'password' => 'secret1234'
       ]);
        
       $response = $this->json('POST', route('login'),[
           'email' => 'test@gmail.com',
           'password' => 'secret1234',
       ]);
       $response->assertStatus(200);
       
       $this->assertEquals('test',$response->json()[0]['name']);

       User::where('email', 'test@gmail.com')->delete();
    }
}
