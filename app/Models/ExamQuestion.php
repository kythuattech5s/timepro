<?php
namespace App\Models;

use multiplechoicequestions\managequestion\Models\Question;

class ExamQuestion extends BaseModel
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}