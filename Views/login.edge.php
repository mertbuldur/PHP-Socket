@extends('layouts.app')
@section('content')
<div class="container">

    {{ \System\SessionManager::flash('status') }}
    <div class="card">
        <div class="card-header">Giriş Yap</div>
        <div class="card-body">
            <form action="/login" method="POST">

                <div class="form-group">
                    <label for="">Email:</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Şifre:</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Giriş Yap</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection