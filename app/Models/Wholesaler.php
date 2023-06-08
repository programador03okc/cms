<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wholesaler extends Model
{
    protected $table = 'admin.wholesalers';
    use SoftDeletes;

    protected $fillable = ['document', 'name', 'address'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
