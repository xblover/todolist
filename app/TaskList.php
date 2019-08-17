<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'lists';
    //
    protected $fillable = [
        'name', 'user_id', 'updated_at', 'created_at'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task','list_id','id');
    }
}
