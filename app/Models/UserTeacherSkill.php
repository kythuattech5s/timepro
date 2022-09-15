<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserTeacherSkill extends BaseModel
{
    use HasFactory;
    protected $table = 'course_course_category';
    public function teacherSkill()
    {
    	return $this->belongsTo(TeacherSkill::class, 'teacher_skill_id', 'id');
    }
}