<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'tasks';
    //
    protected $fillable = [
        'name', 'status', 'list_id', 'tasks_id', 'updated_at','created_at'
    ];

    public function list()
    {
        return $this->belongsTo('App\List','list_id','id');
    }

    public function children()
    {
        return $this->hasMany('App\Task', 'tasks_id' ,'id');
    }

    public function task()
    {
        return $this->belongsTo('App\Task','list_id','id');
    }
}
