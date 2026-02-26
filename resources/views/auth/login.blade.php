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

            @if ($errors->any())
            <div class="error-message">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
                <label>Usuario (Nick):</label>
                <input type="text" name="nick" value="{{ old('nick') }}" placeholder="Tu nombre de usuario">
            </div>

            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>
</body>

</html>