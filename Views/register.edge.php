@extends('layouts.app')
@section('content')
<div class="container">

<div class="card">
    <div class="card-header">Kayıt Ol</div>
    <div class="card-body">
        <form action="/register" method="POST">

            <div class="form-group">
                <label for="">Ad:</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="">Email:</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="">Şifre:</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Kayıt Ol</button>
            </div>

        </form>
    </div>
</div>
</div>

@endsection