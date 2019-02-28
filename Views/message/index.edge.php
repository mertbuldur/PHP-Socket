@extends('layouts.app')
@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <h3 class=" text-center">{{ \App\Models\User::getName($receiverUserId) }} </h3>
    <div class="messaging">
        <div class="inbox_msg">

            <div class="mesgs">
                <div class="msg_history">

                    @foreach($messages as $k => $v)
                    @php
                    if($v['sendUserId'] == \System\SessionManager::GetAuth('id')){
                    $div1 = 'outgoing_msg';
                    $div2 = 'sent_msg';
                    }
                    else
                    {
                    $div1 = 'incoming_msg';
                    $div2 = 'received_msg';
                    }
                    @endphp
                        <div class="{{ $div1 }}">
                            <div class="{{ $div2 }}">
                                <p>{{ $v['text'] }} </p>
                                <span class="time_date">{{ date("H:i:s",strtotime($v['created_at'])) }} </span>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" id="message" class="write_msg" placeholder="Mesajınızı Yazın !" />
                        <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('footer')
        <meta  name="client" content="{{ \System\SessionManager::GetAuth("id")}}" />
        <meta name="messageId" content="{{ $id}}" />
@endsection