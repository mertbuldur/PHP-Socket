@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12" style="text-align: center;">
            <button id="searchUser" style="margin-bottom: 10px;" class="btn btn-success">
                Kullanıcı Aramaya Başla
            </button>

            <div id="searching">
                Kullanıcı Aranıyor(<span id="second">0</span> sn)
            </div>
        </div>
    </div>



@endsection