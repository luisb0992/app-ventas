<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{

    use SoftDeletes;

    /**
     * Divisa Dolar
     *
     * @const string
     */
    const CURRENCY_USD = '$';

    /**
     * Divisa Euro
     *
     * @const string
     */
    const CURRENCY_EURO = '€';

    /**
     * Divisa Bolívar
     *
     * @const string
     */
    const CURRENCY_BS = 'Bs';

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

    /**
     * Marca una venta como verificada
     *
     * @return void
     */
    public function verifySale(): void
    {
        $this->update([
            'verified_at' => now()
        ]);
    }

    /**
     * Devuelve la cantidad en dólares
     *
     * @return string     La cantidad en dólares
     */
    public function getUsdAmountAttribute(): string
    {
        return self::CURRENCY_USD . ' ' . number_format($this->amount, 2, '.', ',');
    }

    /**
     * Devuelve la cantidad en bolivares
     *
     * @return string     La cantidad en dólares
     */
    public function getBsAmountAttribute(): string
    {
        return self::CURRENCY_BS . ' ' . number_format($this->amount, 2, '.', ',');
    }
}
