<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    protected $table = 'admin.tags';
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
