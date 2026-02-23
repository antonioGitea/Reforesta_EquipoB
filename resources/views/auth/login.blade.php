<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFORESTA - LOGIN</title>
</head>

<body>
    <h1>Iniciar Sesión</h1>

    @if (!empty($error))
        <div class="textoError">
            {{ $error }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">

        @csrf

        <div>
            <label for="login">Usuario:</label>
            <input type="text" name="usuario" id="login" />
        </div>

        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" />
        </div>

        <input type="submit" name="enviar" value="Enviar">

    </form>
</body>

</html>