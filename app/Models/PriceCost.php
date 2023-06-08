<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceCost extends Model
{
    protected $table = 'admin.price_costs';
    use SoftDeletes;

    protected $fillable = ['product_id', 'currency_id', 'cost', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
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
