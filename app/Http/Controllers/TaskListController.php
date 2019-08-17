<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskList;
use App\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TaskListController extends Controller
{
    //
    public function createList(Request $request)
    {
        $list = new TaskList();
        if(!empty($request->name)){
            $list->name = $request->name;
            $list->user_id = $request->user_id;
            $list->updated_at =  currentTime();
            $list->created_at =  currentTime();
    
            $list->save();
        }
    }

    public function deleteList(Request $request)
    {
        TaskList::where('id' , $request->id)->delete();
    }

    public function updateList(Request $request)
    {
        TaskList::where('id', $request->id)
          ->update(['name' => $request->name,'updated_at' => currentTime()]);
    }

    public function lists()
    {
        $list = new  TaskList();
        return $list->all();
    }

    public function list(Request $request)
    {
        $list = TaskList::find($request->id)->load(['tasks']);
       
        return $list;

    }

}
