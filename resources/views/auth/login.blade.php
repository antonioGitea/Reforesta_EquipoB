<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/stylesLogin.css') }}">
    <title>REFORESTA - LOGIN</title>
    </head>
<body class="login-body">

    <div class="login-container">
        <form action="{{ route('login') }}" method="POST" class="login-card">
            @csrf

            <h1>Iniciar Sesión</h1>

            @if(!empty($error))
                <div class="error-message">
                    {{ $error }}
                </div>
            @endif

            <div class="form-group">
                <label>Usuario (Nick):</label>
                <input type="text" name="nick" required value="{{ old('nick') }}" placeholder="Tu nombre de usuario">
            </div>

            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>
</body>
</html>