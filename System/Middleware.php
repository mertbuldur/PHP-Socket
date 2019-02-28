<?php
namespace System;
class Middleware
{
    static function run($class,$next)
    {
        return call_user_func_array([new $class,"handle"],[$next]);
    }
}


