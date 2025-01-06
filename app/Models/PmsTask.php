<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmsTask extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany(PmsComment::class, 'task_id', 'id');
    }


    public function projects()
    {
        return $this->hasOne(PmsProject::class, 'id', 'project_id');
    }
}
