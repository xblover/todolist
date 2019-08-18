<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JdOrder extends Model
{
    //
    protected $table = 'jd_orders';

    protected $fillable = ['order_id', 'updated_at', 'full_json', 'fetched_at', 'fetch_confirmed_at'];

    protected $primaryKey = 'order_id';

    public $incrementing = false;

    public  $timestamps = false;
}
