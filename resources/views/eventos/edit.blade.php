<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reforestacion - Reforesta</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
    <style>
        .form-box { background: #161b22; border: 1px solid #30363d; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #8b949e; margin-bottom: 8px; font-weight: bold; }
        .form-control {
            width: 100%; padding: 12px; background: #0d1117; border: 1px solid #30363d;
            color: white; border-radius: 6px; box-sizing: border-box;
        }
        .form-control:focus { border-color: #2ecc71; outline: none; }
        .grid-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .is-invalid { border-color: #ff4444 !important; }
        .error-feedback {
            color: #ff4444;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
            font-weight: bold;
        }
    </style>
</head>
<body class="dark-theme">
    @include('nav')

    <div class="container-show" style="max-width: 800px; margin: 40px auto;">
        <header class="main-header">
            <div>
                <span class="event-tag">Editar</span>
                <h1 class="event-title">Modificar Evento</h1>
            </div>
        </header>

        <div class="form-box">
            <form action="{{ route('eventos.update', $evento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre del Proyecto</label>
                    <input type="text" name="nombre" id="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $evento->nombre) }}">
                    @error('nombre') <span class="error-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="grid-inputs">
                    <div class="form-group">
                        <label for="tipo_evento">Tipo de Evento</label>
                        <select name="tipo_evento" id="tipo_evento" class="form-control @error('tipo_evento') is-invalid @enderror">
                            @foreach(['Siembra', 'Limpieza', 'Riego'] as $opcion)
                                <option value="{{ $opcion }}" {{ old('tipo_evento', $evento->tipo_evento) == $opcion ? 'selected' : '' }}>
                                    {{ $opcion == 'Limpieza' ? 'Limpieza de maleza' : ($opcion == 'Riego' ? 'Riego de mantenimiento' : $opcion) }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_evento') <span class="error-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha del Evento</label>
                        <input type="date" name="fecha" id="fecha"
                               class="form-control @error('fecha') is-invalid @enderror"
                               value="{{ old('fecha', $evento->fecha) }}">
                        @error('fecha') <span class="error-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicacion</label>
                    <input type="text" name="ubicacion" id="ubicacion"
                           class="form-control @error('ubicacion') is-invalid @enderror"
                           value="{{ old('ubicacion', $evento->ubicacion) }}">
                    @error('ubicacion') <span class="error-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="grid-inputs">
                    <div class="form-group">
                        <label for="tipo_terreno">Tipo de Terreno</label>
                        <input type="text" name="tipo_terreno" id="tipo_terreno"
                               class="form-control @error('tipo_terreno') is-invalid @enderror"
                               value="{{ old('tipo_terreno', $evento->tipo_terreno) }}">
                        @error('tipo_terreno') <span class="error-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_especies">Especies sugeridas</label>
                        <select name="id_especies[]" id="id_especies"
                                class="form-control @error('id_especies') is-invalid @enderror"
                                multiple style="height: 100px;">
                            @php
                                $especiesSeleccionadas = old('id_especies', $evento->especies->pluck('id')->toArray());
                            @endphp

                            @foreach($especies as $especie)
                                <option value="{{ $especie->id }}" {{ in_array($especie->id, $especiesSeleccionadas) ? 'selected' : '' }}>
                                    {{ $especie->nombre_cientifico }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_especies') <span class="error-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripcion y Objetivos</label>
                    <textarea name="descripcion" id="descripcion"
                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $evento->descripcion) }}</textarea>
                    @error('descripcion') <span class="error-feedback">{{ $message }}</span> @enderror
                </div>

                <div style="margin-top: 30px; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-join" style="flex: 1;">GUARDAR CAMBIOS</button>
                    <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-edit" style="text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
