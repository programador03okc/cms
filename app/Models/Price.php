<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    protected $table = 'admin.prices';
    use SoftDeletes;

    protected $fillable = ['business_type_id', 'product_id', 'currency_id', 'type', 'cost', 'margin', 'discount', 'price', 'status'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function business_type()
    {
        return $this->belongsTo('App\Models\BusinessType')->withTrashed();
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency')->withTrashed();
    }
}
