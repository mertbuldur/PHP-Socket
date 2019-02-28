<?php

function asset($path)
{
    $sitePath = "http://phpsocket.local/public";
    return $sitePath."/".$path;
}

function redirect($url)
{
    Header('Location: '.$url);
}