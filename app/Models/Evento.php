<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evento extends Model
{
    use HasFactory;
    // La tabla no usa created_at ni updated_at.
    public $timestamps = false;
    
    protected $table = "eventos";
    protected $fillable = ['nombre', 'descripcion', 'ubicacion', 'fecha', 'tipo_terreno', 'tipo_evento', 'imagen','id_usuario'];

    // Usuario que creó el evento.
    public function anfitrion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Usuarios participantes del evento.
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'usuarios_eventos',
            'id_evento',
            'id_usuario'
        );
    }


    // Especies asociadas al evento.
    public function especies(): BelongsToMany
    {
        return $this->belongsToMany(
            Especie::class,
            'eventos_especies',
            'id_evento',
            'id_especie'
        );
    }
}
