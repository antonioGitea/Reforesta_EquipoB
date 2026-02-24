<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFORESTA - LOGIN</title>
</head>

<body>

    @if (!empty($error))
        <div class="textoError">
            {{ $error }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <h1>Iniciar Sesión</h1>

        @if(isset($error))
            <div style="color: red;">{{ $error }}</div>
        @endif

        <div>
            <label>Usuario (Nick):</label>
            <input type="text" name="nick" required value="{{ old('nick') }}">
        </div>

        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Entrar</button>

    </form>
</body>

</html>