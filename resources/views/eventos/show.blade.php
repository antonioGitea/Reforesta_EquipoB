<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $evento->nombre }} | Reforestación</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0d1117; color: #c9d1d9; }
        .species-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; margin-top: 20px; }
        .species-card-item { background: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 16px; transition: transform 0.2s; }
        .species-card-item:hover { transform: translateY(-3px); border-color: #2ecc71; }
        .species-name { color: #58a6ff; font-size: 1.1rem; display: block; margin-bottom: 8px; }
        .benefit-tag { background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem; }
        .admin-panel { background: #161b22; border: 2px dashed #30363d; border-radius: 12px; padding: 25px; margin-top: 50px; }
        .custom-select { background: #0d1117; border: 1px solid #30363d; color: white; border-radius: 8px; width: 100%; padding: 10px; outline: none; }
        .custom-select option { padding: 10px; }
    </style>
</head>

<body class="dark-theme">
    @include('nav')

    <div class="container-show" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        @if(session('success'))
            <div style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border: 1px solid #2ecc71; padding: 10px 14px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: rgba(248, 81, 73, 0.15); color: #f85149; border: 1px solid #f85149; padding: 10px 14px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        
        {{-- Header del Evento --}}
        <header class="main-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 1px solid #30363d; padding-bottom: 30px;">
            <div>
                <span class="event-tag" style="background: #238636; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">
                    {{ $evento->tipo_evento }}
                </span>
                <h1 class="event-title" style="font-size: 2.5rem; margin: 15px 0; color: #f0f6fc;">{{ $evento->nombre }}</h1>
                <div class="event-meta" style="display: flex; gap: 20px; color: #8b949e;">
                    <span>📍 {{ $evento->ubicacion }}</span>
                    <span>📅 {{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}</span>
                    <span>🌳 {{ $evento->tipo_terreno }}</span>
                </div>
            </div>

            @auth
                @if(auth()->id() == $evento->id_usuario || auth()->user()->tipo == 'admin')
                    <div class="header-actions" style="display: flex; gap: 10px;">
                        <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-edit" style="background: #30363d; color: #c9d1d9; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">Modificar</a>
                        <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete" style="background: rgba(248, 81, 73, 0.1); color: #f85149; border: 1px solid #f85149; padding: 10px 20px; border-radius: 6px; cursor: pointer;" onclick="return confirm('¿Estás seguro de eliminar este evento?')">Eliminar</button>
                        </form>
                    </div>
                @endif
            @endauth
        </header>

        <div class="show-grid" style="display: grid; grid-template-columns: 1fr 350px; gap: 40px;">
            
            {{-- LADO IZQUIERDO: CONTENIDO --}}
            <div class="main-content">
                <section>
                    <h2 class="section-title" style="color: #f0f6fc; border-left: 4px solid #238636; padding-left: 15px; margin-bottom: 20px;">Sobre esta reforestación</h2>
                    <p style="line-height: 1.6; font-size: 1.1rem; color: #8b949e;">{{ $evento->descripcion }}</p>
                </section>

                <section style="margin-top: 50px;">
                    <h2 class="section-title" style="color: #f0f6fc; border-left: 4px solid #238636; padding-left: 15px;">Especies a tratar</h2>
                    <div class="species-grid">
                        @foreach($evento->especies as $especie)
                            <div class="species-card-item">
                                <strong class="species-name">{{ $especie->nombre_cientifico }}</strong>
                                <span class="benefit-tag">🌱 {{ $especie->beneficios }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- PANEL DE ADMINISTRACIÓN DE ESPECIES --}}
                @auth
                    @if(auth()->id() == $evento->id_usuario || auth()->user()->tipo == 'admin')
                        <div class="admin-panel">
                            <h3 style="margin-top: 0; color: #2ecc71; display: flex; align-items: center; gap: 10px;">
                                🛠️ Panel de Gestión de Especies
                            </h3>
                            <p style="color: #8b949e; font-size: 0.9rem; margin-bottom: 20px;">Actualizar la lista de especies que se tratarán en este evento.</p>

                            <form action="{{ route('eventos.updateEspecies', $evento->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div style="margin-bottom: 20px;">
                                    <select name="especies[]" multiple class="custom-select" style="height: 200px;">
                                        @foreach($especies as $item)
                                            <option value="{{ $item->id }}" {{ $evento->especies->contains($item->id) ? 'selected' : '' }}>
                                                {{ $item->nombre_comun }} ({{ $item->nombre_cientifico }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p style="font-size: 0.8rem; color: #6e7681; margin-top: 10px;"> Usa Ctrl + Click para seleccionar varias.</p>
                                </div>
                                <button type="submit" style="background: #238636; color: white; border: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%;">
                                    Guardar Cambios en la Lista
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            {{-- LADO DERECHO: SIDEBAR --}}
            <aside class="sidebar">
                <div class="sidebar-box" style="background: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 25px; position: sticky; top: 20px;">
                    
                    <h3 style="margin-top: 0; font-size: 1rem; color: #8b949e; text-transform: uppercase;">Organizador</h3>
                    <div class="user-card" style="display: flex; align-items: center; gap: 12px; background: #0d1117; padding: 12px; border-radius: 8px;">
                        <img src="https://ui-avatars.com/api/?name={{ $evento->anfitrion->nick ?? 'A' }}&background=238636&color=fff" style="width: 45px; height: 45px; border-radius: 50%;">
                        <div>
                            <span style="display: block; font-weight: bold; color: #f0f6fc;">{{ $evento->anfitrion->nick ?? 'Anónimo' }}</span>
                            <small style="color: #238636;">Anfitrión del evento</small>
                        </div>
                    </div>

                    <h3 style="margin-top: 30px; font-size: 1rem; color: #8b949e; text-transform: uppercase;">Participantes ({{ $evento->usuarios->count() }})</h3>
                    <div class="participants-list" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach($evento->usuarios as $participante)
                            <div class="user-card" style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <img src="https://ui-avatars.com/api/?name={{ $participante->nick }}&background=30363d&color=fff" style="width: 30px; height: 30px; border-radius: 50%;">
                                <span style="font-size: 0.9rem;">{{ $participante->nick }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="sidebar-actions">
                        @auth
                            @if(auth()->id() != $evento->id_usuario)
                                @if($evento->usuarios->contains('id', auth()->id()))
                                    <button type="button" disabled style="background: #30363d; color: #8b949e; width: 100%; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: not-allowed;">
                                        YA ESTAS UNIDO
                                    </button>
                                @else
                                    <form action="{{ route('eventos.unirse', $evento->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: #238636; color: white; width: 100%; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer;">
                                            UNIRME AL EVENTO
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" style="display: block; text-align: center; background: #30363d; color: white; padding: 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                                Inicia sesión para participar
                            </a>
                        @endauth
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
