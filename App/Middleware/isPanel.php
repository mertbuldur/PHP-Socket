<?php
namespace  App\Middleware;
use App\Middleware\src\MiddlewareInterface;
use System\SessionManager;

class isPanel implements MiddlewareInterface
{
    public function handle($next)
    {
        // TODO: Implement handle() method.
        if(SessionManager::isAuth())
        {
            redirect('/panel');
        }
    }
}