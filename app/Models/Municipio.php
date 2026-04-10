<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Productor; // ← AGREGAR ESTA LÍNEA

class Municipio extends Model
{
    protected $fillable = [
        'nombre', 
        'slug', 
        'codigo_postal_prefix', 
        'descripcion', 
        'imagen', 
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($municipio) {
            if (!$municipio->slug) {
                $municipio->slug = Str::slug($municipio->nombre);
            }
        });
    }

    public function productores(): HasMany
    {
        return $this->hasMany(Productor::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}