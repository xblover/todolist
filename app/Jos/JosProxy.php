<?php


namespace App\Jos;


interface JosProxy
{
    public function send($params):?object;
}
