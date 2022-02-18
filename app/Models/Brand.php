<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

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
        'logo',
        'email_one',
        'email_two'
    ];

    /**
     * Devuelve las marcas ordenadas
     *
     * @return Collection    Las marcas ordenadas por id
     */
    public static function getOrderBrands(): Collection
    {
        return self::orderBy('id', 'desc')->get();
    }
}
