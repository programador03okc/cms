<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryIntcomex extends Model
{
    protected $table = 'intcomex.inventory_intcomexes';
    use SoftDeletes;

    protected $fillable = ['Sku', 'Mpn', 'InStock'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
