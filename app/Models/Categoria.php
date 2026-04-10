<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Producto;
class Categoria extends Model
{
    protected $fillable = [
        'nombre', 'slug', 'icono', 'imagen', 'descripcion', 
        'color', 'orden', 'destacado', 'activo'
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($categoria) {
            if (!$categoria->slug) {
                $categoria->slug = Str::slug($categoria->nombre);
            }
        });
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDestacadas($query)
    {
        return $query->where('destacado', true);
    }

    public function getUrlAttribute(): string
    {
        return route('catalogo.categoria', $this->slug);
    }
}