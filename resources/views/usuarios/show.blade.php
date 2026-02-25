<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de {{ $usuario->nick }}</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
</head>
<body class="dark-theme">
    @include('nav')

    <div class="container-show">
        <header class="main-header">
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="https://ui-avatars.com/api/?name={{ $usuario -> nick }}&background=2ecc71&color=fff"" 
                     alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #2ecc71;">
                
                <div>
                    <span class="event-tag">{{ ucfirst($usuario->tipo) }}</span>
                    <h1 class="event-title">{{ $usuario->nick }}</h1>
                    <div class="event-meta">
                        <span class="meta-item">👤 {{ $usuario->nombre ?? 'Sin nombre configurado' }}</span>
                        <span class="meta-item">📧 {{ $usuario->email }}</span>
                        <span class="meta-item">📍 {{ $usuario->ubicacion ?? 'Ubicación desconocida' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="show-grid">
            <div class="main-content">
                <h2 class="section-title">Estadísticas de Usuario</h2>
                <div class="species-card" style="display: flex; justify-content: space-around; text-align: center;">
                    <div>
                        <p style="font-size: 0.9em; color: #888;">Karma</p>
                        <strong style="font-size: 2em; color: #2ecc71;">{{ $usuario->karma }}</strong>
                    </div>
                    <div>
                        <p style="font-size: 0.9em; color: #888;">Miembro desde</p>
                        <strong style="font-size: 1.2em;">{{ $usuario->created_at->format('M Y') }}</strong>
                    </div>
                    <div>
                        <p style="font-size: 0.9em; color: #888;">Email Verificado</p>
                        <strong>{{ $usuario->email_verified_at ? '✅ Sí' : '❌ No' }}</strong>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <div class="sidebar-box">
                    <h2 class="section-title">Sobre el rango</h2>
                    <div class="user-card">
                        @if($usuario->tipo == 'admin')
                            <span class="user-nick" style="color: #e74c3c;">Administrador del Sistema</span>
                        @else
                            <span class="user-nick">Colaborador de Reforestación</span>
                        @endif
                    </div>

                    <h2 class="section-title" style="margin-top:30px">Información Técnica</h2>
                    <ul style="list-style: none; padding: 0; color: #ccc; font-size: 0.9em;">
                        <li style="margin-bottom: 10px;">🆔 ID de Usuario: {{ $usuario->id }}</li>
                        <li style="margin-bottom: 10px;">⏳ Última actualización: {{ $usuario->updated_at->diffForHumans() }}</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
