<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    class Especie extends Model {
        use HasFactory;
        public $timestamps = false;
        
        protected $table = "especies";
        protected $fillable = [
            'nombre_cientifico',
            'tiempo_para_adultez',
            'region_origen',
            'clima',
            'enlace_descripcion',
            'foto_especie',
            'beneficios'
        ];

        public function eventos(): BelongsToMany
        {
            return $this->belongsToMany(
                Evento::class,
                'eventos_especies', 
                'id_especie', 
                'id_evento'
            );
        }
    }