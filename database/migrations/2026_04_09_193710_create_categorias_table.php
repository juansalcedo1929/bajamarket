<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('icono')->nullable();
            $table->string('imagen')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('color')->default('#22c55e');
            $table->integer('orden')->default(0);
            $table->boolean('destacado')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};