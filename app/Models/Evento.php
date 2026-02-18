<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = "eventos";
    protected $fillable = ['nombre', 'descripcion', 'ubicacion', 'fecha', 'tipo_terreno', 'tipo_evento', 'imagen'];
    
    //Relación: Evento -> Usuario (Anfitrión)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}

?>