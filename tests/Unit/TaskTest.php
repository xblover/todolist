<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_a_todo()
    {
        //user‘s data
        $name = 'testtest';
        $data = [
            'name' => $name,
            'status' => 1,
            'list_id' => 1,
        ];
        $old = Task::where($data)->count();
        //send post request
        $response = $this->withoutExceptionHandling()->json('POST',route('createTask'),$data);
        //assert it was successful
        $response->assertStatus(200);
        $new = Task::where($data)->count();
        $this->assertEquals(1,$new-$old);

        Task::where($data)->delete();
    }

    /** @test */
    public function create_a_nil_value_todo()
    {
        //user‘s data
        $name = '';
        $data = [
            'name' => $name,
            'status' => 1,
            'list_id' => 1,
        ];
        $old = Task::where($data)->count();
        //send post request
        $response = $this->withoutExceptionHandling()->json('POST',route('createTask'),$data);
        //assert it was successful
        $response->assertStatus(200);
        $new = Task::where($data)->count();
        $this->assertEquals(0,$new-$old);

        Task::where($data)->delete();
    }

    /** @test */
    public function create_a_zi_todo()
    {
        //user‘s data
        $name = 'testtest';
        $data = [
            'name' => $name,
            'status' => 1,
            'list_id' => 1,
            'tasks_id' => 1
        ];
        $old = Task::where($data)->count();
        //send post request
        $response = $this->withoutExceptionHandling()->json('POST',route('createTask'),$data);
        //assert it was successful
        $response->assertStatus(200);
        $new = Task::where($data)->count();
        $this->assertEquals(1,$new-$old);

        Task::where($data)->delete();
    }

    /** @test */
    public function delete_a_todo()
    {
        $name = 'testtest';
        $data = [
            'name' => $name,
            'status' => 1,
            'list_id' => 1,
        ];
        $res = Task::create($data);
        $old = Task::where($data)->count();
        $response = $this->json('POST',route('deleteTask'),['id'=>$res->id]);
        $response->assertStatus(200);
        $new = Task::where($data)->count();
        $this->assertEquals(1,$old-$new);

    }

    /** @test */
    public function update_a_todo()
    {
        $name = 'testtest';
        $data = [
            'name' => $name,
            'status' => 1,
            'list_id' => 1,
        ];
        $res = Task::create($data);
        $response = $this->withoutExceptionHandling()->json('POST',route('updateTask',['id'=>$res->id]),[
            'status' => 2,
        ]);
        $response->assertStatus(200);
        
        $task = Task::where('id',$res->id)->first();
        $task = json_decode($task->toJson());
        $this->assertEquals(2,$task->status);

        Task::where('id',$res->id)->delete();
    }

    /** @test */
    public function select_todolists()
    {
        //????如何验证子任务，建立task与task的关联

        $name1 = 'testtest';
        $name2 = 'test';
        $data = [
            'name' => $name1,
            'status' => 1,
            'list_id' => 1,
        ];
        $res = Task::create($data);
    
        $data2 = [
            'name' => $name2,
            'status' => 1,
            'list_id' => 1,
            'tasks_id' => $res->id
        ];
        $res2 = Task::create($data2);

        $response = $this->withoutExceptionHandling()->json('GET',route('taskList',['id'=>$res->id]));
        $response->assertStatus(200);
    
        $this->assertEquals($name1 , $response->json()['name']);
        $this->assertEquals($name2 , $response->json()['children'][0]['name']);

        Task::where($data)->delete();
        Task::where($data2)->delete();
    }

}
