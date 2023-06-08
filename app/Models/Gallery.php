<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    protected $table = 'admin.galleries';
    use SoftDeletes;

    protected $fillable = ['art_type_id', 'section_id', 'name', 'path', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function art_type()
    {
        return $this->belongsTo('App\Models\ArtType')->withTrashed();
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
