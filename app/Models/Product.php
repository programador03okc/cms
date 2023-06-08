<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'admin.products';
    use SoftDeletes;

    protected $fillable = [
        'part_number', 'sku', 'name', 'title', 'subtitle', 'slug_large', 'slug_short', 'model', 'category_id', 'subcategory_id', 'mark_id', 'unit_id', 
        'detail', 'link', 'link_index', 'status', 'stock', 'stock_reserv', 'cost', 'wholesaler_id', 'user_id', 'correlative'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category')->withTrashed();
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory')->withTrashed();
    }

    public function mark()
    {
        return $this->belongsTo('App\Models\Mark')->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function specifications()
    {
        return $this->hasMany('App\Models\Specification');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price');
    }

    public function arts()
    {
        return $this->hasMany('App\Models\Art');
    }
}
