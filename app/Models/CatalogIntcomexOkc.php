<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogIntcomexOkc extends Model
{
    protected $table = 'intcomex.catalog_intcomex_okcs';
    use SoftDeletes;

    protected $fillable = [
        'Sku', 'Mpn', 'Description', 'Type', 'ManufacturerId', 'BrandId', 'Brand_Description',
        'CategoryId', 'Category_Description', 'Subcategory_CategoryId', 'Subcategory_Description'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
