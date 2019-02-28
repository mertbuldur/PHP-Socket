<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
session_start();
require_once  'config/functions.php';
require_once  'vendor/autoload.php';
require  'Routes/Router.php';

// indexController@index
Router::start('/','indexController@index','get',['App\Middleware\isPanel']);
Router::start('/logout','indexController@logout','get',['\App\Middleware\isAuth']);
Router::start('/login','indexController@login','get',['\App\Middleware\isQuest']);
Router::start('/login','indexController@loginStore','post');


Router::start('/register','indexController@register','get',['\App\Middleware\isQuest']);
Router::start('/register','indexController@registerStore','post');

Router::start('/panel','panel\indexController@index','get',['\App\Middleware\isAuth']);
Router::start('/panel/search','panel\indexController@search','post',['\App\Middleware\isAuth']);


Router::start('/message/start/{receiverUserId}','message\indexController@start','get',['\App\Middleware\isAuth']);
Router::start('/message/send/{messageId}','message\indexController@send','post',['\App\Middleware\isAuth']);
Router::start('/message/update/{messageId}','message\indexController@update','post',['\App\Middleware\isAuth']);