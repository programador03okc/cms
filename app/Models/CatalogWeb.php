<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogWeb extends Model
{
    protected $table = 'temp.catalog_webs';
    use SoftDeletes;

    protected $fillable = ['title', 'name', 'path', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
