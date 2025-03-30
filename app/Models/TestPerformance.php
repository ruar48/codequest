<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPerformance extends Model
{
    protected $table = "test_performances";
    protected $fillable = ['user_id', 'question_id', 'answer', 'is_correct', 'points'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
