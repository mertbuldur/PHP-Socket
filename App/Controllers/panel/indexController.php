<?php
namespace App\Controllers\panel;
use App\Models\Message;
use App\Models\User;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use System\controller;
use System\SessionManager;

class indexController extends controller
{

    public function index()
    {
        User::where('id',SessionManager::GetAuth("id"))->update(['status'=>0]);
        $users = User::where('id','!=',SessionManager::GetAuth("id"))->get();
        self::view('panel/index',['users'=>$users]);
    }

    public function search()
    {
        if(!$_POST){ die();}
        if(SessionManager::GetAuth("status") == 0) {
            User::where('id', SessionManager::GetAuth("id"))->update(['status' => 1]);

            $count = User::where('status', 1)->where('id', '!=', SessionManager::GetAuth("id"))->count();
            if ($count != 0) {
                $w = User::where('status', 1)->where('id', '!=', SessionManager::GetAuth("id"))->limit(1)->get();
                $receiverUserId = $w[0]['id'];
                try {
                    $client = new Client(new Version2X('http://localhost:3000', [
                        'headers' => [
                            'X-My-Header: websocket rocks',
                            'Authorization: Bearer 12b3c4d5e6f7g8h9i'
                        ]
                    ]));
                    $client->initialize();
                    $client->emit('search', ['sendUserId'=>SessionManager::GetAuth("id"),'receiverUserId' => $receiverUserId]);
                    User::where('id', SessionManager::GetAuth("id"))->update(['status' => 2]);

                    $client->close();
                    echo json_encode(['status' => false]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo json_encode(['status' => true]);
            }

        }
        else
        {
            echo json_encode(['status'=>true]);
        }


    }


}