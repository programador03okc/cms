<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    protected $table = 'admin.subcategories';
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'category_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category')->withTrashed();
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
