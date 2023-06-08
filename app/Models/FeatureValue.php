<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureValue extends Model
{
    protected $table = 'admin.feature_values';
    use SoftDeletes;

    protected $fillable = ['feature_id', 'value_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function feature()
    {
        return $this->belongsTo('App\Models\Feature')->withTrashed();
    }

    public function value()
    {
        return $this->belongsTo('App\Models\Value')->withTrashed();
    }
}
