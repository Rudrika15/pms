<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmsComment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
