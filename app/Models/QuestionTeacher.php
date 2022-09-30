<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTeacher extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->belongsToMany(User::class, 'question_teacher_user', 'question_teacher_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(QuestionTeacher::class, 'question_teacher_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(QuestionTeacher::class, 'question_teacher_id', 'id');
    }

    public static function getQuestion($courseId)
    {
        return self::where('map_id', $courseId)->where('map_table', 'courses')->orderBy('id','DESC')->whereNull('question_teacher_id')->paginate(5);
    }
}
