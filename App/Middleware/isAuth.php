<?php
namespace App\Middleware;
use App\Middleware\src\MiddlewareInterface;
use System\SessionManager;

class isAuth implements MiddlewareInterface
{
    public function handle($next)
    {
        if(!SessionManager::isAuth())
        {
            redirect('/');
        }
        return $next;
    }
}