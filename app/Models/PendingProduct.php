<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingProduct extends Model
{
    protected $table = 'admin.pending_products';
    use SoftDeletes;

    protected $fillable = [
        'Sku', 'Mpn', 'Description', 'Type', 'ManufacturerId', 'BrandId', 'Brand_Description',
        'CategoryId', 'Category_Description', 'Subcategory_CategoryId', 'Subcategory_Description',
        'UnitPrice', 'CurrencyId', 'InStock', 'Status'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
