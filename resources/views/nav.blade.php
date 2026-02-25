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
                    <a href="{{ route('usuarios.show', auth()->id()) }}" class="nav-avatar-link">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nick }}&background=2ecc71&color=fff"
                            alt="Avatar" class="nav-avatar">
                    </a>

                    <form action="{{ route('auth.logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar Sesión</button>
                    </form>
                </div>

                <a href="{{ route('usuarios.index') }}">USUARIOS</a>
                <a href="{{ route('eventos.create') }}">CREAR EVENTO</a>
                <a href="{{ route('especies.index') }}">ESPECIES</a>
            @endauth

            <a href="{{ route('home') }}">INICIO</a>

            @guest
                <a href="{{ route('login') }}" class="btn-login">INICIAR SESIÓN</a>
                <a href="{{ route('usuarios.create') }}" class="btn-login">REGISTRARSE</a>
            @endguest
        </div>
    </nav>
</body>

</html>