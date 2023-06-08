<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogIntcomex extends Model
{
    protected $table = 'intcomex.catalog_intcomexes';
    use SoftDeletes;

    protected $fillable = [
        'Sku', 'Mpn', 'Description', 'Type', 'ManufacturerId', 'BrandId', 'Brand_Description',
        'CategoryId', 'Category_Description', 'Subcategory_CategoryId', 'Subcategory_Description'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
