<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventos.css') }}">
</head>
<body>
    @include('nav')

    <div class="container">
        <h2 class="title">Eventos</h2>

        @if($eventos->isEmpty())
            <p>No hay eventos disponibles en este momento.</p>
        @else
            <div class="events-grid">
                @foreach($eventos as $evento)
                    <div class="event-card">
                        <div class="card-image">
                            @if($evento->imagen)
                                <img src="{{ asset('storage/' . $evento->imagen) }}" alt="{{ $evento->nombre }}">
                            @else
                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/38/Arboleda_Navarra.jpg" alt="Sin imagen">
                            @endif
                            <span class="badge">{{ $evento->tipo_evento }}</span>
                        </div>

                        <div class="card-content">
                            <h3>{{ $evento->nombre }}</h3>
                            <p class="date">📅 {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
                            <p class="location">📍 {{ $evento->ubicacion }}</p>
                            <p class="terrain">⛰️ Terreno: {{ $evento->tipo_terreno }}</p>
                            
                            <div class="full-description">
                                {{ $evento->descripcion }}
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-details">Detalles</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>