<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mark extends Model
{
    protected $table = 'admin.marks';
    use SoftDeletes;

    protected $fillable = ['name', 'logo', 'path'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
