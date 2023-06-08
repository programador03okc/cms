<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSegment extends Model
{
    protected $table = 'admin.product_segments';
    use SoftDeletes;

    protected $fillable = ['segment_id', 'product_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function segment()
    {
        return $this->belongsTo('App\Models\Segment')->withTrashed();
    }
}
