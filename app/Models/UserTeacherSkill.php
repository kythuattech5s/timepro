<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserTeacherSkill extends BaseModel
{
    use HasFactory;
    protected $table = 'user_teacher_skill';
    public function teacherSkill()
    {
    	return $this->belongsTo(TeacherSkill::class, 'teacher_skill_id', 'id');
    }
}