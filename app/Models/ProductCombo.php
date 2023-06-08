<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCombo extends Model
{
    protected $table = 'admin.product_combos';
    use SoftDeletes;

    protected $fillable = ['code', 'product_id', 'product_combo_id', 'price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function product_combo()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }
}
