<?php
namespace App\Middleware;
use App\Middleware\src\MiddlewareInterface;
use System\SessionManager;

class isQuest implements MiddlewareInterface
{
  public function handle($next)
  {
        if(SessionManager::isAuth())
        {
            redirect('/');
        }
        return $next;
  }
}