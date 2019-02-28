<?php
namespace System;
use App\Models\User;

class SessionManager
{

    static function destroyAuth()
    {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    }

    static function saveSession($array  =[])
    {
        foreach ($array as $k => $v)
        {
            $_SESSION[$k] = $v;
        }
    }

    static function get($k)
    {
        if(isset($_SESSION[$k]))
        {
            return $_SESSION[$k];
        }
        else
        {
            return null;
        }
    }

    static function flash($name = '',$message = '',$class = 'success')
    {

        if(!empty($name))
        {
            if(!empty($message) && empty($_SESSION[$name]))
            {
                if(!empty($_SESSION[$name]))
                {
                    unset($_SESSION[$name]);
                }
                if(!empty($_SESSION[$name.'_class']))
                {
                    unset($_SESSION[$name.'_class']);
                }
                $_SESSION[$name] = $message;
                $_SESSION[$name.'_class'] = $class;
            }
            elseif(!empty($_SESSION[$name]) && empty($message))
            {
                echo '<div class="alert alert-'.$_SESSION[$name.'_class'].'">'.$_SESSION[$name].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name.'_class']);
            }
        }
    }


    static function isAuth()
    {
        $c = User::where('email',self::get("email"))->where('password',self::get("password"))->count();
        if($c !=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    static function GetAuth($field)
    {
        if(self::isAuth())
        {
            $w = User::where('email',self::get("email"))->where('password',self::get("password"))->get();
            return $w[0][$field];
        }
        else
        {
            return null;
        }
    }


}