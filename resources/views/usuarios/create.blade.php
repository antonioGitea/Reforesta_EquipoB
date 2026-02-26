<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/stylesLogin.css') }}">
    <title>REFORESTA - REGISTRO</title>
    <style>
        .error-message { color: #ff4444; font-size: 0.8rem; margin-top: 5px; display: block; }
        input.is-invalid { border: 1px solid #ff4444 !important; }
    </style>
</head>
<body class="login-body">

    <div class="login-container">
        <form action="{{ route('usuarios.store') }}" method="POST" class="login-card">
            @csrf

            <h1>Crear Cuenta</h1>

            <div class="form-group">
                <label>Usuario (Nick):</label>
                <input type="text" name="nick" value="{{ old('nick') }}" 
                       class="{{ $errors->has('nick') ? 'is-invalid' : '' }}">
                @error('nick') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" 
                       class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}">
                @error('nombre') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Ubicación:</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" 
                       class="{{ $errors->has('ubicacion') ? 'is-invalid' : '' }}" 
                       placeholder="Ej: Madrid, España">
                @error('ubicacion') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" 
                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                @error('password') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Repetir Contraseña:</label>
                <input type="password" name="password_confirmation">
            </div>

            <button type="submit" class="btn-submit">Registrarse</button>

            <p style="margin-top: 15px; text-align: center;">
                <a href="{{ route('login') }}" style="color: #2ecc71; text-decoration: none;">¿Ya tienes cuenta? Entra aquí</a>
            </p>
        </form>
    </div>
</body>
</html>