<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TaskList;
use App\Task;

class ListTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function create_a_list()
    {
        //user‘s data
        $name = 'testtest';
        $data = [
            'name' => $name,
            'user_id' => 1
        ];
        $old = TaskList::where($data)->count();
        //send post request
        $response = $this->withoutExceptionHandling()->json('POST',route('createList'),$data);
        //assert it was successful
        $response->assertStatus(200);
        $new = TaskList::where($data)->count();
        $this->assertEquals(1,$new-$old);

        TaskList::where($data)->delete();
    }

    /** @test */
    public function create_a_nil_value_list()
    {
        //user‘s data
        $name = '';
        $data = [
            'name' => $name,
            'user_id' => 1
        ];
        $old = TaskList::where('name',$name)->count();
        //send post request
        $response = $this->withoutExceptionHandling()->json('POST',route('createList'),$data);
        //assert it was successful
        $response->assertStatus(200);
        $new = TaskList::where('name',$name)->count();
        $this->assertEquals(0,$new-$old);

        TaskList::where($data)->delete();
    }

    /** @test */
    public function delete_a_list()
    {
        $data = [
            'name' => 'testtest',
            'user_id' => 1
        ];
        $res = TaskList::create($data);
        $old = TaskList::where($data)->count();
        $response = $this->withoutExceptionHandling()->json('POST',route('deleteList'),['id'=>$res->id]);
        $response->assertStatus(200);
        $new = TaskList::where($data)->count();
        $this->assertEquals(1,$old-$new);

    }

    /** @test */
    public function update_a_list()
    {
        $data = [
            'name' => 'testtest',
            'user_id' => 1
        ];
        $res = TaskList::create($data);
        $response = $this->withoutExceptionHandling()->json('POST',route('updateList',['id'=>$res->id]),[
            'name' => 'test',
        ]);
        $response->assertStatus(200);
        
        $task = TaskList::where('id',$res->id)->first();
        $task = json_decode($task->toJson());
        $this->assertEquals('test',$task->name);

        TaskList::where('id',$res->id)->delete();
    }

    /** @test */
    public function select_lists()
    {
        $name = 'testtest';
        $data = [
            'name' => $name,
            'user_id' => 1,
        ];
        $res = TaskList::create($data);

        $response = $this->json('GET',route('lists'));
        $response->assertStatus(200);
        
        $task = $response->json();
        $this->assertEquals(1 , count($task));
        $this->assertEquals($name , $task[0]['name']);

        TaskList::where($data)->delete();
    }

    /** @test */
    public function show_a_list()
    {
        $name = 'testtest';
        $data = [
            'name' => $name,
            'user_id' => 1,
        ];
        $res = TaskList::create($data);
        $data2 = [
            'name' => $name,
            'list_id' => $res->id,
            'status' => 1,
        ];
        $res2 = Task::create($data2);

        $response = $this->withoutExceptionHandling()->json('GET',route('list'),['id'=>$res->id]);
        $response->assertStatus(200);
        $this->assertEquals($name , $response->json()['name']);
        $this->assertEquals($name , $response->json()['tasks'][0]['name']);

        TaskList::where($data)->delete();
        Task::where($data2)->delete();
        
    }
}
