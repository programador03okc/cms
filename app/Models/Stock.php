<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    protected $table = 'admin.stocks';
    use SoftDeletes;

    protected $fillable = ['business_type_id', 'store_shop_id', 'type', 'product_id', 'stock', 'stock_web', 'stock_order', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    public function business_type()
    {
        return $this->belongsTo('App\Models\BusinessType')->withTrashed();
    }

    public function store_shop()
    {
        return $this->belongsTo('App\Models\StoreShop')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
