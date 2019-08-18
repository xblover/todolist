<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    //
    protected $table = "tokens";

    protected $fillable = ['access_token', 'md5_access_token','checked_at','revoked_at'];

    public function checkedWithinFiveMinutes(): bool
    {
        if (!$this->checked_at){
            return false;
        }
        return Carbon::parse($this->checked_at)->diffInSeconds() <= 300;
    }
}
