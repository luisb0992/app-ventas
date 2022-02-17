<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
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
}
