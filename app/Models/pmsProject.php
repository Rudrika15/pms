<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmsProject extends Model
{
    public function teams()
    {
        return $this->hasMany(PmsTeam::class, 'project_id', 'id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, PmsTeam::class, 'project_id', 'id', 'id', 'user_id');
    }
}
