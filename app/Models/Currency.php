<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    protected $table = 'admin.currencies';
    use SoftDeletes;

    protected $fillable = ['name', 'simbol'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
