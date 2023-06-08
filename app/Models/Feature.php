<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    protected $table = 'admin.features';
    use SoftDeletes;

    protected $fillable = ['category_id', 'name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category')->withTrashed();
    }
}
