<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nick', 'nombre', 'email', 'ubicacion', 'karma', 'avatar', 'tipo', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Eventos que el usuario ha creado (como Anfitrión)
     * Relación 1:N -> Un usuario crea muchos eventos.
     */
    public function eventos_creados(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_usuario');
    }

    /**
     * Eventos en los que el usuario participa
     * Relación M:N -> A través de la tabla 'usuarios_eventos'
     */
    public function eventos_participo(): BelongsToMany
    {
        return $this->belongsToMany(
            Evento::class, 
            'usuarios_eventos', // Tabla intermedia
            'id_usuario',       // Clave foránea de este modelo en la intermedia
            'id_evento'         // Clave foránea del modelo destino en la intermedia
        );
    }
}

?>