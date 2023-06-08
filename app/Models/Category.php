<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'admin.categories';
    use SoftDeletes;

    protected $fillable = ['name', 'image', 'path'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
