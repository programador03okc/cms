<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListDownload extends Model
{
    protected $table = 'intcomex.list_downloads';
    use SoftDeletes;

    protected $fillable = ['date', 'action', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
