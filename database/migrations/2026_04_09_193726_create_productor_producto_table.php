<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productor_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productor_id')->constrained('productores')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            $table->string('presentacion')->nullable();
            $table->string('variedad')->nullable();
            $table->string('calidad')->nullable();
            $table->string('disponibilidad')->nullable();
            $table->string('volumen_minimo')->nullable();
            $table->boolean('organico')->default(false);
            $table->json('precios_referencia')->nullable();
            $table->text('notas')->nullable();
            
            $table->timestamps();
            
            $table->unique(['productor_id', 'producto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('productor_producto');
    }
};