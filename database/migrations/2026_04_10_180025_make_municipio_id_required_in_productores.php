<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Primero, asignar un municipio por defecto a los que tengan NULL
        $municipioDefault = DB::table('municipios')->first();
        if ($municipioDefault) {
            DB::table('productores')
                ->whereNull('municipio_id')
                ->orWhere('municipio_id', 0)
                ->update(['municipio_id' => $municipioDefault->id]);
        }

        // Luego modificar la columna para que sea NOT NULL
        Schema::table('productores', function (Blueprint $table) {
            $table->foreignId('municipio_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('productores', function (Blueprint $table) {
            $table->foreignId('municipio_id')->nullable()->change();
        });
    }
};