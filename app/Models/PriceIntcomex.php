<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceIntcomex extends Model
{
    protected $table = 'intcomex.price_intcomexes';
    use SoftDeletes;

    protected $fillable = ['Sku', 'Mpn', 'UnitPrice', 'CurrencyId'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
