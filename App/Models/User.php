<?php
namespace App\Models;
use System\Model;
class User extends  Model
{
    protected  $table = "users";
    protected  $guarded = [];


    static function getName($id)
    {
        $w = User::where('id',$id)->get();
        return $w[0]['name'];
    }
}