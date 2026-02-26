<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Reforestación - Reforesta</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
    <style>
        .form-box {
            background: #161b22;
            border: 1px solid #30363d;
            padding: 30px;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #8b949e;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background: #0d1117;
            border: 1px solid #30363d;
            color: white;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #2ecc71;
            outline: none;
        }

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Estilos de validación */
        .is-invalid {
            border-color: #ff4444 !important;
        }

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

    <div class="container-show" style="max-width: 700px; margin: 40px auto;">
        <header class="main-header">
            <span class="event-tag">Nuevo</span>
            <h1 class="event-title">Crear Evento</h1>
        </header>

        <form action="{{ route('eventos.store') }}" method="POST" class="form-box">
            @csrf

            <div class="form-group">
                <label>Nombre del Proyecto</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Reforestación Sierra Norte">
                @error('nombre') <span class="error-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="grid-inputs" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                {{-- Tipo de Evento --}}
                <div class="form-group">
                    <label>Tipo de Evento</label>
                    <select name="tipo_evento" class="form-control">
                        @foreach(['Siembra', 'Limpieza', 'Riego'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_evento') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha --}}
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}">
                    @error('fecha') <span class="error-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Ubicación --}}
            <div class="form-group">
                <label>Ubicación</label>
                <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
                @error('ubicacion') <span class="error-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="grid-inputs" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                {{-- Terreno --}}
                <div class="form-group">
                    <label>Tipo de Terreno</label>
                    <input type="text" name="tipo_terreno" class="form-control" value="{{ old('tipo_terreno') }}">
                </div>

                {{-- Especies (Multiselect) --}}
                <div class="form-group">
                    <label>Especies sugeridas</label>
                    <select name="id_especies[]" class="form-control" multiple style="height: 80px;">
                        @foreach($especies as $e)
                        <option value="{{ $e->id }}" {{ collect(old('id_especies'))->contains($e->id) ? 'selected' : '' }}>
                            {{ $e->nombre_cientifico }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion') <span class="error-feedback">{{ $message }}</span> @enderror
            </div>

            {{-- Botones --}}
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-join" style="flex: 2;">PUBLICAR</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-edit" style="flex: 1; text-align: center; text-decoration: none;">CANCELAR</a>
            </div>
        </form>
    </div>
</body>

</html>