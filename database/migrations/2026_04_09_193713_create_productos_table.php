<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion');
            $table->longText('contenido')->nullable();
            $table->string('imagen_principal');
            $table->json('galeria')->nullable();
            $table->string('temporada')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->json('especificaciones')->nullable();
            $table->json('beneficios')->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('disponible')->default(true);
            $table->integer('vistas')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};