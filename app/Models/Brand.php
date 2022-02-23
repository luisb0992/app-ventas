<?php

namespace App\Models;

use App\Http\Traits\BrandTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    use BrandTrait;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * Los atributos que son asignables
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'email_one',
        'email_two'
    ];

    /**
     * Devuelve las ventas de la marca
     *
     * @return HasMany    Las ventas de la marca
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class)->orderBy('created_at', 'desc');
    }

    /**
     * Devuelve las marcas ordenadas
     *
     * @return Collection    Las marcas ordenadas por id
     */
    public static function getOrderBrands(): Collection
    {
        return self::orderBy('id', 'desc')->get();
    }

    /**
     * Busca la marca por el slug indicado
     *
     * @return Self     La marca
     */
    public static function getBrandForSlug(string $slug): ?Brand
    {
        return self::where('slug', $slug)->first();
    }
}
