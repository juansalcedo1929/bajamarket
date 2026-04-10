<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Productor extends Model
{
    use SoftDeletes;

    protected $table = 'productores';

    protected $fillable = [
        'user_id', 'municipio_id', 'nombre_empresa', 'slug', 'nombre_contacto',
        'rfc', 'email', 'telefono_principal', 'telefono_secundario', 'whatsapp',
        'sitio_web', 'direccion', 'colonia', 'codigo_postal', 'latitud', 'longitud',
        'descripcion', 'logo', 'banner', 'certificaciones', 'metodos_pago',
        'horario_atencion', 'facebook', 'instagram', 'twitter', 'estatus',
        'motivo_rechazo', 'aprobado_en', 'aprobado_por', 'vistas', 'contactos', 'destacado'
    ];

    protected $casts = [
        'certificaciones' => 'array',
        'metodos_pago' => 'array',
        'horario_atencion' => 'array',
        'destacado' => 'boolean',
        'aprobado_en' => 'datetime'
    ];

 protected static function boot()
{
    parent::boot();
    
    static::creating(function ($productor) {
        if (!$productor->slug) {
            $productor->slug = Str::slug($productor->nombre_empresa);
        }
        
        // Asegurar que siempre tenga municipio
        if (!$productor->municipio_id) {
            $municipioDefault = Municipio::first();
            if ($municipioDefault) {
                $productor->municipio_id = $municipioDefault->id;
            }
        }
    });
}
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aprobadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'productor_producto')
                    ->withPivot([
                        'presentacion', 'variedad', 'calidad', 
                        'disponibilidad', 'volumen_minimo', 
                        'organico', 'precios_referencia', 'notas'
                    ])
                    ->withTimestamps();
    }

    public function scopeAprobados($query)
    {
        return $query->where('estatus', 'aprobado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'pendiente');
    }

    /**
     * Obtener URL del logo
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && file_exists(public_path('storage/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }
        
        return asset('images/default-producer.png');
    }

    /**
     * Obtener URL del banner
     */
    public function getBannerUrlAttribute(): string
    {
        if ($this->banner && file_exists(public_path('storage/' . $this->banner))) {
            return asset('storage/' . $this->banner);
        }
        
        return '';
    }

    public function getUrlAttribute(): string
    {
        return route('directorio.show', $this->slug);
    }
}