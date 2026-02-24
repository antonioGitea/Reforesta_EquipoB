<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/stylesNav.css') }}">
</head>

<body>
    <nav class="main-nav">
        <div class="nav-links">
            @auth
                {{-- Solo se ve si está LOGUEADO --}}
                <div class="user-profile">
                    <span class="user-name">{{ auth()->user()->nick }}</span>
                    
                    {{-- Usamos la API de avatars temporalmente para que NO se vea la imagen rota --}}
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nick }}&background=2ecc71&color=fff" alt="Avatar" class="nav-avatar">

                    <form action="{{ route('auth.logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar Sesión</button>
                    </form>
                </div>
            @endauth

            <a href="{{ route('home') }}">INICIO</a>
            <a href="{{ route('usuarios.index') }}">USUARIOS</a>
            <a href="{{ route('eventos.create') }}">CREAR EVENTO</a>

            @guest
                <a href="{{ route('auth.login') }}" class="btn-login">INICIAR SESIÓN</a>
            @endguest
        </div>
    </nav>
</body>

</html>