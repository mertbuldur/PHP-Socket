<?php
namespace  App\Models;
use System\Model;
use System\SessionManager;

class Message extends Model
{
    protected  $guarded = [];

    static function isReadCount()
    {
        $notifications = Message::leftJoin('message_contents','messages.id','=','message_contents.messageId')
            ->where(function ($notifications){
                $notifications->orWhere('messages.sendUserId',SessionManager::GetAuth("id"));
                $notifications->orWhere('messages.receiverUserId',SessionManager::GetAuth("id"));
            })
            ->where('message_contents.sendUserId','!=',SessionManager::GetAuth("id"))
            ->where('message_contents.isRead',1)
            ->groupBy('messageId')
            ->select(['message_contents.*'])
            ->count();
        return $notifications;
    }

    static function isReadCountUser($userId)
    {
        $notifications = Message::leftJoin('message_contents','messages.id','=','message_contents.messageId')
            ->where(function ($notifications) use ($userId){
                $notifications->orWhere('messages.sendUserId',$userId);
                $notifications->orWhere('messages.receiverUserId',$userId);
            })
            ->where('message_contents.sendUserId','!=',$userId)
            ->where('message_contents.isRead',1)
            ->groupBy('messageId')
            ->select(['message_contents.*'])
            ->count();
        return $notifications;
    }
}