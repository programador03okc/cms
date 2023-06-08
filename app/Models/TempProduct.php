<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempProduct extends Model
{
    protected $table = 'admin.temp_products';
    use SoftDeletes;

    protected $fillable = ['code', 'month', 'type', 'subcategory', 'category', 'anexo', 'name', 'stock'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
