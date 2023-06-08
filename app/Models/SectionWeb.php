<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionWeb extends Model
{
    protected $table = 'admin.section_webs';
    use SoftDeletes;

    protected $fillable = ['name', 'page'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
