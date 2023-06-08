<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTag extends Model
{
    protected $table = 'admin.product_tags';
    use SoftDeletes;

    protected $fillable = ['tag_id', 'product_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag')->withTrashed();
    }
}
