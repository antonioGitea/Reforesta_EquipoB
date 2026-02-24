<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $evento->nombre }}</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
</head>
<body class="dark-theme">
    @include('nav')

    <div class="container-show">
        <header class="main-header">
            <div>
                <span class="event-tag">{{ $evento->tipo_evento }}</span>
                <h1 class="event-title">{{ $evento->nombre }}</h1>
                <div class="event-meta">
                    <span class="meta-item">📍 {{ $evento->ubicacion }}</span>
                    <span class="meta-item">📅 {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</span>
                    <span class="meta-item">🌳 {{ $evento->tipo_terreno }}</span>
                </div>
            </div>

            <div class="header-actions">
                @auth
                    @if(auth()->id() == $evento->id_usuario || auth()->user()->tipo == 'admin')
                        <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-edit">Modificar</a>
                        <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('¿Borrar evento?')">Eliminar</button>
                        </form>
                    @endif
                @endauth
            </div>
        </header>

        <div class="show-grid">
            <div class="main-content">
                <h2 class="section-title">Sobre esta reforestación</h2>
                <p>{{ $evento->descripcion }}</p>

                <h2 class="section-title" style="margin-top:40px">Especies a tratar</h2>
                @foreach($evento->especies as $especie)
                    <div class="species-card">
                        <strong>{{ $especie->nombre_cientifico }}</strong>
                        <p>🌱 {{ $especie->beneficios }}</p>
                    </div>
                @endforeach
            </div>

            <aside class="sidebar">
                <div class="sidebar-box">
                    <h2 class="section-title">Organizador</h2>
                    <div class="user-card">
                        <img src="https://ui-avatars.com/api/?name={{ $evento->anfitrion->nick }}&background=2ecc71&color=fff" class="user-avatar">
                        <span class="user-nick">{{ $evento->anfitrion->nick }} <small>(Anfitrión)</small></span>
                    </div>

                    <h2 class="section-title" style="margin-top:30px">Participantes ({{ $evento->usuarios->count() }})</h2>
                    @foreach($evento->usuarios as $participante)
                        <div class="user-card">
                            <img src="https://ui-avatars.com/api/?name={{ $participante->nick }}&background=30363d&color=fff" class="user-avatar-small">
                            <span class="user-nick-small">{{ $participante->nick }}</span>
                        </div>
                    @endforeach

                    <div class="sidebar-actions" style="margin-top: 20px;">
                        @auth
                            @if(auth()->id() != $evento->id_usuario)
                                <form action="{{ route('eventos.unirse', $evento->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-join">UNIRME AL EVENTO</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('auth.login') }}" class="btn btn-edit" style="display: block; text-align: center;">Inicia sesión para participar</a>
                        @endauth
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>