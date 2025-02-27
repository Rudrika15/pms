<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmsTeam extends Model
{
    public function project()
    {
        return $this->belongsTo(PmsProject::class, 'project_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
