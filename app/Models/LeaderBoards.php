<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderBoards extends Model
{
    protected $table = "levels";
    protected $fillable = [
        'user_id',
        'level_number',
        'stars',
        'points',
    ];
}
