<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    //
    public function createTask(Request $request)
    {
        $task = new Task();
        if(!empty($request->name)){
            $task->name = $request->name;
            $task->status = $request->status;
            $task->list_id = $request->list_id;
            $task->tasks_id = !empty($request->tasks_id) ? $request->tasks_id  : 0;
            $task->updated_at =  currentTime();
            $task->created_at =  currentTime();
    
            $task->save();
        }
    }
    
    
    public function deleteTask(Request $request)
    {
        Task::where('id' , $request->id)->delete();
    }

    public function updateTask(Request $request)
    {
        Task::where('id', $request->id)
          ->update(['status' => $request->status,'updated_at' => currentTime()]);
    }

    public function taskList(Request $request)
    {
        $task = Task::find($request->id)->load(['children']);
        return $task;
    }
    
}
