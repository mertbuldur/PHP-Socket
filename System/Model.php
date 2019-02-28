<?php
namespace System;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
           'driver'=>'mysql',
           'host'=>'localhost',
           'database'=>'phpsocket',
           'username'=>'root',
           'password'=>'',
           'charset'=>'utf8',
           'collation'=>'utf8_general_ci',
           'prefix'=>''
        ]);

        //$capsule->setEventDispatcher(new Dispatcher(new Container));
        //$capsule->setAsGlobal();
        $capsule->bootEloquent();


    }
}