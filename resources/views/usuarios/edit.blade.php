<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Modificar Perfil - {{ $usuario->nick }}</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
</head>

<body class="dark-theme">
    @include('nav')

    <div class="container-show">
        <header class="main-header">
            <div>
                <span class="event-tag">Configuración</span>
                <h1 class="event-title">Editar Perfil</h1>
            </div>
        </header>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="show-grid">
                {{-- Columna Principal --}}
                <div class="main-content">
                    <h2 class="section-title">Datos Personales</h2>

                    <div class="species-card" style="background: #2d333b; padding: 25px; border-radius: 10px; margin-bottom: 30px;">
                        {{-- Campo Nombre --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Nombre Completo</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                            @error('nombre') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                        </div>

                        {{-- Campo Nick --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Nickname</label>
                            <input type="text" name="nick" value="{{ old('nick', $usuario->nick) }}"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                            @error('nick') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                        </div>

                        {{-- Campo Ubicación --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Ubicación</label>
                            <input type="text" name="ubicacion" value="{{ old('ubicacion', $usuario->ubicacion) }}"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                            @error('ubicacion') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                        </div>

                        {{-- Campo Email --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                            @error('email') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <h2 class="section-title">Seguridad</h2>
                    <div class="species-card" style="background: #2d333b; padding: 25px; border-radius: 10px;">
                        <p style="font-size: 0.8em; color: #777; margin-bottom: 15px;">Deja en blanco si no deseas cambiar la contraseña.</p>
                        <div style="margin-bottom: 20px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Nueva Contraseña</label>
                            <input type="password" name="password"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                            @error('password') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display:block; margin-bottom: 8px; color: #888;">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation"
                                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 5px;">
                        </div>
                    </div>

                    <hr style="border-color: #444; margin: 20px 0;">

                    <h2 class="section-title">Acciones</h2>
                    <div class="sidebar-actions">
                        <button type="submit" class="btn btn-join" style="width: 100%; margin-bottom: 10px; border: none; cursor: pointer;">
                            GUARDAR CAMBIOS
                        </button>
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-edit"
                            style="display: block; text-align: center; background: #444; text-decoration: none;">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>