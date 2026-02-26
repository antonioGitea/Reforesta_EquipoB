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

    // Eventos creados por este usuario.
    public function eventos_creados(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_usuario');
    }

    // Eventos en los que este usuario participa.
    public function eventos_participo(): BelongsToMany
    {
        return $this->belongsToMany(
            Evento::class,
            'usuarios_eventos', // Tabla pivote.
            'id_usuario',       // FK del usuario.
            'id_evento'         // FK del evento.
        );
    }
}
