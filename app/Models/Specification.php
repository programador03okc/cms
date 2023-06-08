<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specification extends Model
{
    protected $table = 'admin.specifications';
    use SoftDeletes;

    protected $fillable = ['product_id', 'feature_value_id', 'feature_content'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function feature_value()
    {
        return $this->belongsTo('App\Models\FeatureValue')->withTrashed();
    }
}
