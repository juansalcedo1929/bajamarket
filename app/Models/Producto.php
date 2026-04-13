<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Models\Categoria; 
use App\Models\Productor;
class Producto extends Model
{
    protected $table = 'productos'; 
    protected $fillable = [
        'categoria_id', 'nombre', 'slug', 'descripcion', 'contenido',
        'imagen_principal', 'galeria', 'temporada', 'unidad_medida',
        'especificaciones', 'beneficios', 'destacado', 'disponible'
    ];

    protected $casts = [
        'galeria' => 'array',
        'especificaciones' => 'array',
        'beneficios' => 'array',
        'destacado' => 'boolean',
        'disponible' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($producto) {
            if (!$producto->slug) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function productores(): BelongsToMany
    {
        return $this->belongsToMany(Productor::class, 'productor_producto')
                    ->withPivot([
                        'presentacion', 'variedad', 'calidad', 
                        'disponibilidad', 'volumen_minimo', 
                        'organico', 'precios_referencia', 'notas'
                    ])
                    ->withTimestamps();
    }

    public function productoresAprobados()
    {
        return $this->productores()->where('estatus', 'aprobado');
    }

    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true);
    }

public function getImagenPrincipalUrlAttribute(): string
{
    if ($this->imagen_principal) {
        // Si ya es una URL externa (HTTP/HTTPS), la devolvemos tal cual
        if (filter_var($this->imagen_principal, FILTER_VALIDATE_URL)) {
            return $this->imagen_principal;
        }
        
        // Usar la ruta personalizada que sirve archivos directamente desde storage
        return route('storage.image', ['path' => $this->imagen_principal]);
    }
    
    // Imagen por defecto (puedes poner una URL de placeholder o ruta local)
    return asset('images/default-product.jpg');
}
    public function getUrlAttribute(): string
    {
        return route('producto.show', $this->slug);
    }
}