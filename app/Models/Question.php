<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'output', 'level', 'tips'];

    public function testPerformances()
    {
        return $this->hasMany(TestPerformance::class, 'question_id');
    }
}
