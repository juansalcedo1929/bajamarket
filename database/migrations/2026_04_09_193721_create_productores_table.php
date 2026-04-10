<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('municipio_id')->constrained();
            
            $table->string('nombre_empresa');
            $table->string('slug')->unique();
            $table->string('nombre_contacto');
            $table->string('rfc')->nullable();
            $table->string('email');
            $table->string('telefono_principal');
            $table->string('telefono_secundario')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('sitio_web')->nullable();
            $table->text('direccion');
            $table->string('colonia')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->json('certificaciones')->nullable();
            $table->json('metodos_pago')->nullable();
            $table->json('horario_atencion')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            
            $table->enum('estatus', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('motivo_rechazo')->nullable();
            $table->timestamp('aprobado_en')->nullable();
            $table->foreignId('aprobado_por')->nullable()->constrained('users');
            $table->integer('vistas')->default(0);
            $table->integer('contactos')->default(0);
            $table->boolean('destacado')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productores');
    }
};