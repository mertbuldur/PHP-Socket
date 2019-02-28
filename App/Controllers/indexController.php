<?php
namespace App\Controllers;
use App\Models\User;
use System\controller;
use System\SessionManager;

class indexController extends controller
{

    public function index()
    {
        self::view("index");
    }


    public function login()
    {
        self::view('login');
    }

    public function logout()
    {
        SessionManager::destroyAuth();
        redirect('/');
    }


    public function loginStore()
    {
        if(!$_POST){ die();}
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $c = User::where('email',$email)->where('password',md5($password))->count();
        if($c!=0)
        {
            $w = User::where('email',$email)->where('password',md5($password))->get();
            SessionManager::saveSession(['email'=>$w[0]['email'],'password'=>$w[0]['password']]);
            redirect('/panel');
        }
        else
        {
            SessionManager::flash('status','Böyle bir kullanıcı Yok','danger');
            redirect("/login");
        }


    }


    public function register()
    {
        self::view('register');
    }

    public function registerStore()
    {

        if(!$_POST){ die(); }
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $name = strip_tags($_POST['name']);
        if($email!="" and $password!="" and $name!="")
        {
            $c = User::where('email',$email)->count();
            if($c==0){

                $x = new User;
                $x->name = $name;
                $x->email = $email;
                $x->password = md5($password);
                $x->save();


              redirect("/login");
            }
            else
            {
                redirect("/register");
            }
        }
        else
        {
            redirect("/register");
        }


    }






}