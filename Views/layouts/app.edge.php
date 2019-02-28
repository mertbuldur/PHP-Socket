<html>
<head>
    <title>PHP SOCKET APPLICATION</title>
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom:30px;">
    <a href="" class="navbar-brand">PHPSOCKET</a>
    <button data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportContent" class="navbar-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a href="/" class="nav-link">Anasayfa</a>
            </li>
            @if(!\System\SessionManager::isAuth())
            <li class="nav-item">
                <a href="/register" class="nav-link">Kayıt Ol</a>
            </li>

            <li class="nav-item">
                <a href="/login" class="nav-link">Giriş Yap</a>
            </li>
            @else
            <li class="nav-item">
                <a href="/" class="nav-link">{{ \System\SessionManager::GetAuth('name') }} <span class="m-count">({{ \App\Models\Message::isReadCount() }})</span> </a>
            </li>
            <li class="nav-item">
                <a href="/logout" class="nav-link"> Çıkış Yap</a>
            </li>
            @endif

        </ul>
        <form action="" class="form-inline my-2 my-lg-0">
            <input type="text" class="form-control mr-sm-2" >
            <button class="btn btn-outline-success my-2 my-sm0">Ara</button>
        </form>


    </div>
</nav>

@yield('content')


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="{{ asset('dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('dist/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script>
    var socket = io("http://localhost:3000");
    socket.emit('connection_user',{'client':'{{ \System\SessionManager::GetAuth("id") }}'})
    socket.on('message_count_show',function (result) {
        $(".m-count").text('('+result.count+')');
    })
</script>

@yield('footer')
</body>
</html>