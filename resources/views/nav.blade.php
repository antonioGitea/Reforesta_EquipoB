<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/stylesNav.css') }}">
</head>

<body>
    <nav>
        
        <ul>
            <li> <a href="{{ route('eventos.index') }}">Inicio</a> </li>
            <li> <a href="{{ route('usuarios.index') }}">Usuarios</a> </li>
            <li> <a href="{{ route('eventos.create') }}">Crear Evento</a> </li>
        </ul>
        
    </nav>
</body>

</html>