<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecutedCode extends Model
{
    protected $table = "php_executions";
    protected $fillable = ['user_id','code', 'output', 'is_error'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
