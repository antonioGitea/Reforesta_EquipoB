<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Especie extends Model {
        protected $table = "especies";
        protected $fillable = 
                            [   'nombre_cientifico',
                                'tiempo_para_adultez',
                                'region_origne',
                                'clima',
                                'enlace_descripcion',
                                'foto_especie',
                                'beneficios'
                            ];
    }
?>