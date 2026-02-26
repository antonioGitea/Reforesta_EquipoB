<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Especies</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventos.css') }}">
</head>
<body>
    @include('nav')

    <div class="container">
        <h2 class="title">Especies Disponibles</h2>

        {{-- Mensaje por defecto si no hay Especies --}}
        @if($especies->isEmpty())
            <p>No hay especies registradas en el catálogo.</p>
        @else
            <div class="events-grid">
                {{-- Recorremos el listado y mostramos los datos de cada especie --}}
                @foreach($especies as $especie)
                    <div class="event-card">
                        <div class="card-image">
                            @if($especie->foto_especie)
                                <img src="{{ $especie->foto_especie }}" alt="{{ $especie->nombre_cientifico }}">
                            @else
                                {{-- Imagen por defecto si no hay foto --}}
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Plant_icon_noun_project_1142.svg" alt="Sin imagen" style="padding: 20px; opacity: 0.5;">
                            @endif
                            <span class="badge">{{ $especie->clima }}</span>
                        </div>

                        <div class="card-content">
                            <h3 style="font-style: italic;">{{ $especie->nombre_cientifico }}</h3>
                            <p class="location">🌍 Origen: {{ $especie->region_origen }}</p>
                            <p class="terrain">⏳ Crecimiento: {{ $especie->tiempo_para_adultez }}</p>
                            
                            <div class="full-description" style="margin-top: 10px; font-size: 0.9em; color: #666;">
                                {{ Str::limit($especie->beneficios, 100) }}
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('especies.show', $especie->id) }}" class="btn btn-details">Ficha Técnica</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
