<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtType extends Model
{
    protected $table = 'admin.art_types';
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function arts()
    {
        return $this->hasMany('App\Models\Art');
    }
}
