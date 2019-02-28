<?php
namespace App\Middleware\src;
interface MiddlewareInterface
{
    public function handle($next);
}