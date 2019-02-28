<?php
namespace App\Controllers\message;
use App\Models\Message;
use App\Models\MessageContent;
use App\Models\User;
use System\controller;
use System\SessionManager;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Illuminate\Support\Facades\Auth;

class indexController  extends controller
{
    public function start($receiverUserId)
    {
       $c = User::where('id',$receiverUserId)->count();
       if($c!=0 and $receiverUserId != SessionManager::GetAuth("id"))
       {
            $messageCount = Message::where(function ($messageCount) use ($receiverUserId){
                $messageCount->where('receiverUserId',$receiverUserId);
                $messageCount->where('sendUserId',SessionManager::GetAuth("id"));
            })->orWhere(function ($messageCount) use ( $receiverUserId){
                $messageCount->where('sendUserId',$receiverUserId);
                $messageCount->where('receiverUserId',SessionManager::GetAuth("id"));
            })->count();
            if($messageCount == 0)
            {
                $messageInsert = new Message;
                $messageInsert->sendUserId = SessionManager::GetAuth("id");
                $messageInsert->receiverUserId = $receiverUserId;
                $messageInsert->save();
                $messageID = $messageInsert->id;

            }
            else
            {
                $messageData = Message::where(function ($messageCount) use ($receiverUserId){
                    $messageCount->where('receiverUserId',$receiverUserId);
                    $messageCount->where('sendUserId',SessionManager::GetAuth("id"));
                })->orWhere(function ($messageCount) use ( $receiverUserId){
                    $messageCount->where('sendUserId',$receiverUserId);
                    $messageCount->where('receiverUserId',SessionManager::GetAuth("id"));
                })->get();
                $messageID = $messageData[0]['id'];
            }

            User::where('id',SessionManager::GetAuth("id"))->update(['status'=>2]);
            $messages = MessageContent::where('messageId',$messageID)->orderBy('id','asc')->get();
            $array = ['receiverUserId'=>$receiverUserId,'id'=>$messageID,'messages'=>$messages];

            self::view('message/index',$array);

       }
       else
       {
           redirect('/');
       }
    }


    public function update($messageId)
    {
        if(!$_POST){ die(); }
         MessageContent::where('messageId',$messageId)->where('sendUserId','!=',SessionManager::GetAuth("id"))->update(['isRead'=>0]);
        echo json_encode(['status'=>Message::isReadCount()]);
    }


    public function send($messageId)
    {
        if(!$_POST){ die();}

        $c = Message::where('id',$messageId)->where(function ($c){
           $c->orWhere('sendUserId',SessionManager::GetAuth("id"));
           $c->orWhere('receiverUserId',SessionManager::GetAuth("id"));
        })->count();
        if($c!=0)
        {
            $w = Message::where('id',$messageId)->where(function ($c){
                $c->orWhere('sendUserId',SessionManager::GetAuth("id"));
                $c->orWhere('receiverUserId',SessionManager::GetAuth("id"));
            })->get();
            if($w[0]['sendUserId'] == SessionManager::GetAuth("id"))
            {
                $receiverUserId = $w[0]['receiverUserId'];
            }
            else
            {
                $receiverUserId = $w[0]['sendUserId'];
            }


            $text = strip_tags($_POST['text']);
            $returnArray = [];
            $returnArray['text'] = $text;
            $returnArray['time'] = date("H:i:s");
            $messageContentInsert = new  MessageContent;
            $messageContentInsert->sendUserId = SessionManager::GetAuth("id");
            $messageContentInsert->messageId = $messageId;
            $messageContentInsert->text = $text;
            $messageContentInsert->save();
            try {
                $client = new Client(new Version2X('http://localhost:3000', [
                    'headers' => [
                        'X-My-Header: websocket rocks',
                        'Authorization: Bearer 12b3c4d5e6f7g8h9i'
                    ]
                ]));


                $client->initialize();
                $client->emit('send_message', ['time'=>date("H:i:s"),'messageId'=>$messageId,'text' => $text,'receiverUserId'=>$receiverUserId]);
                $client->emit('send_message_notifications',['receiverUserId'=>$receiverUserId,'count'=>Message::isReadCountUser($receiverUserId)]);
                $client->close();
            }
            catch (\Exception $e)
            {
                echo $e->getMessage();
            }
            echo json_encode($returnArray);
        }

    }
}