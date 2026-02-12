<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Usuario extends Model {
        protected $table = "";
        protected $fillable = ['nick','nombre','email','ubicacion','avatar','tipo','password'];
    }

?>