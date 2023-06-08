<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Art extends Model
{
    protected $table = 'admin.arts';
    use SoftDeletes;

    protected $fillable = ['art_type_id', 'product_id', 'name', 'path', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function art_type()
    {
        return $this->belongsTo('App\Models\ArtType')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
