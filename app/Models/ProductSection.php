<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSection extends Model
{
    protected $table = 'admin.product_sections';
    use SoftDeletes;

    protected $fillable = ['section_web_id', 'product_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function section_web()
    {
        return $this->belongsTo('App\Models\SectionWeb')->withTrashed();
    }
}
