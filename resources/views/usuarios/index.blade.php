<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/stylesUsuarios.css') }}">
</head>
    <body>
        @include('nav')

        <div class="container">
            <h2 class="title">Comunidad</h2>

            @if($usuarios->isEmpty())
                <p>No hay usuarios registrados en este momento.</p>
            @else
                <div class="events-grid"> @foreach($usuarios as $usuario)
                        <div class="event-card"> <div class="card-image">
                                @if($usuario->avatar)
                                    <img src="{{ asset('storage/' . $usuario->avatar) }}" alt="{{ $usuario->nick }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nick) }}&background=random" alt="Avatar">
                                @endif
                                <span class="badge">{{ $usuario->tipo ?? 'Miembro' }}</span>
                            </div>

                            <div class="card-content">
                                <h3>{{ $usuario->nick }}</h3>
                                <p class="name">👤 {{ $usuario->nombre ?? 'Sin nombre' }}</p>
                                <p class="location">📍 {{ $usuario->ubicacion ?? 'Ubicación desconocida' }}</p>
                                <p class="karma">⭐ Karma: {{ $usuario->karma }}</p>
                                
                                <div class="full-description">
                                    <p>Email: {{ $usuario->email }}</p>
                                    <small>Miembro desde: {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}</small>
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-details">Ver Perfil</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </body>
</html>