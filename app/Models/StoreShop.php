<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreShop extends Model
{
    protected $table = 'admin.store_shops';
    use SoftDeletes;

    protected $fillable = ['name', 'website'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
