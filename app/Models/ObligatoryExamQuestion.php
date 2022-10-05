<?php
namespace App\Models;

use multiplechoicequestions\managequestion\Models\Question;

class ObligatoryExamQuestion extends BaseModel
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}