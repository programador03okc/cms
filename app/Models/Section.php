<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    protected $table = 'admin.sections';
    use SoftDeletes;

    protected $fillable = ['name', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery');
    }
}
