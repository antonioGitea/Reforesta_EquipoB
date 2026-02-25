<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $especie->nombre_cientifico }}</title>
    <link rel="stylesheet" href="{{ asset('css/stylesEventoShow.css') }}">
</head>

<body class="dark-theme">
    @include('nav')

    <div class="container-show">
        <header class="main-header">
            <div>
                <span class="event-tag">Especie Botánica</span>
                <h1 class="event-title" style="font-style: italic;">{{ $especie->nombre_cientifico }}</h1>
                <div class="event-meta">
                    <span class="meta-item">🌍 {{ $especie->region_origen }}</span>
                    <span class="meta-item">☁️ Clima: {{ $especie->clima }}</span>
                    <span class="meta-item">⏳ Adultez en: {{ $especie->tiempo_para_adultez }}</span>
                </div>
            </div>
        </header>

        <div class="show-grid">
            <div class="main-content">
                <div style="text-align: center; margin-bottom: 30px;">
                    @if($especie->foto_especie)
                    <img src="{{ asset('storage/' . $especie->foto_especie) }}"
                        alt="{{ $especie->nombre_cientifico }}"
                        style="max-width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                    @else
                        <img src="https://concepto.de/wp-content/uploads/2019/04/botanica-800x400.png"
                            style="max-width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                    @endif
                </div>

                <h2 class="section-title">Beneficios Ecológicos</h2>
                <p style="font-size: 1.1em; line-height: 1.6;">{{ $especie->beneficios }}</p>

                @if($especie->enlace_descripcion)
                <div style="margin-top: 30px; padding: 20px; background: #23292f; border-radius: 8px;">
                    <h3 style="color: #2ecc71; font-size: 1em;">📖 Documentación Externa</h3>
                    <p>Puedes encontrar más información técnica sobre esta especie en el siguiente enlace:</p>
                    <a href="{{ $especie->enlace_descripcion }}" target="_blank" style="color: #3498db;">
                        {{ $especie->enlace_descripcion }} 🔗
                    </a>
                </div>
                @endif
            </div>

            <aside class="sidebar">
                <div class="sidebar-box">
                    <h2 class="section-title">Ficha Resumen</h2>
                    <ul style="list-style: none; padding: 0; color: #8b949e;">
                        <li style="margin-bottom: 10px;"><strong>ID de Registro:</strong> #{{ $especie->id }}</li>
                        <li style="margin-bottom: 10px;"><strong>Clima Ideal:</strong> {{ $especie->clima }}</li>
                        <li style="margin-bottom: 10px;"><strong>Zona:</strong> {{ $especie->region_origen }}</li>
                    </ul>

                    <div class="sidebar-actions" style="margin-top: 30px;">
                        <a href="{{ route('especies.index')}}" class="btn btn-edit">Volver al Listado</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>

</html>