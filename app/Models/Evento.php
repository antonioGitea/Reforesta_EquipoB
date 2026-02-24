<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evento extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = "eventos";
    protected $fillable = ['nombre', 'descripcion', 'ubicacion', 'fecha', 'tipo_terreno', 'tipo_evento', 'imagen','id_usuario'];

    public function anfitrion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'usuarios_eventos',
            'id_evento',
            'id_usuario'
        );
    }


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