<?php



class Router
{
    static function currentUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    static function start($url,$callback,$method = "get",$middlewares = [])
    {

        $methodArray = explode(',',strtoupper($method));
        if(in_array($_SERVER['REQUEST_METHOD'],$methodArray)) {


            $url = preg_replace('/\{(.*?)\}/', '(.*)', $url);
            if (preg_match('@^' . $url . '$@', self::currentUrl(), $parameters)) {
                unset($parameters[0]);
                if (is_callable($callback)) {
                    call_user_func_array($callback, $parameters);
                } else {
                    $currentController = explode('@', $callback);
                    $pathController = str_replace('\\','//',$currentController[0]);
                    if (file_exists('App/Controllers/' . $pathController . '.php')) {

                        if(count($middlewares)!=0)
                        {
                            foreach ($middlewares as $k => $v)
                            {
                                \System\Middleware::run(new $v,function ($return)
                                {
                                    return $return;
                                });
                            }
                        }


                        call_user_func_array(['App\\Controllers\\' . $currentController[0], $currentController[1]], $parameters);


                    } else {
                        die(' 404 Class is Not Found');
                    }


                }
            }
        }
    }
}