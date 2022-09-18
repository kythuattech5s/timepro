<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AskAndAnswer extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->belongsToMany(User::class, 'ask_and_answer_like', 'ask_and_answer_id', 'user_id');
    }

    public function asks()
    {
        return $this->hasMany(AskAndAnswer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
