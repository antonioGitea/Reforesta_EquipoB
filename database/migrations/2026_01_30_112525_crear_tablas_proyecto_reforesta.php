<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Método en el que creamos el esquema de BDD
     */
    public function up(): void
    {

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nick')->unique();
            $table->string('nombre')->nullable();
            $table->string('email')->unique();
            $table->string('ubicacion')->nullable();
            $table->integer('karma')->default(0);
            $table->string('avatar')->nullable();
            $table->string('tipo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo_terreno')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->string('imagen')->nullable();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
        });

        Schema::create('especies', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cientifico')->unique();
            $table->string('tiempo_para_adultez')->nullable();
            $table->string('region_origen')->nullable();
            $table->string('clima')->nullable();
            $table->string('enlace_descripcion')->nullable();
            $table->string('foto_especie')->nullable();
            $table->string('beneficios')->nullable();
        });

        Schema::create('usuarios_eventos', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_evento')->constrained('eventos')->onDelete('cascade');
            $table->primary(columns: ['id_usuario', 'id_evento']);

        });

        Schema::create('eventos_especies', function (Blueprint $table) {
            $table->foreignId('id_evento')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('id_especie')->constrained('especies')->onDelete('cascade');
            $table->primary(columns: ['id_evento', 'id_especie']);    
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_especies');
        Schema::dropIfExists('usuarios_eventos');
        Schema::dropIfExists('especies');
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('usuarios');
    }
};
