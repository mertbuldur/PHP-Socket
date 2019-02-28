<?php
namespace System;
use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;
class controller
{

    static function view($path,$parameters = [])
    {
        $paths = ['Views'];
        $edge = new Edge(new EdgeFileLoader($paths));

        echo $edge->render($path,$parameters);



    }
}