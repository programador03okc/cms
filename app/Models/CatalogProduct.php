<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogProduct extends Model
{
    protected $table = 'temp.catalog_products';
    use SoftDeletes;

    protected $fillable = ['month', 'type', 'code', 'part_number', 'category', 'subcategory', 'anexo', 'name', 'stock'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
