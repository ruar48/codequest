<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = "levels";
    protected $fillable = [
        'user_id',
        'level_number',
        'stars',
        'points',
    ];

    // Relationship: A level belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
