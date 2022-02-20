<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{

    use SoftDeletes;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * Los atributos que son asignables
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',         // ID de la marca
        'service',          // Servicio
        'count',            // Cantidad
        'amount',           // Monto
        'client',           // Cliente
        'voucher',          // Comprobante o certificado
        'verified_at',      // Fecha de verificación
    ];

    /**
     * Relación con la marca
     *
     * @return BelongsTo        Devuelve la marca o null si no existe
     */
    public function brand(): ?BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Devuelve true si la venta ha sido verificada
     *
     * @return bool      True si fue verificada
     */
    public function hasItBeenVerified(): bool
    {
        return $this->verified_at !== null;
    }
}
