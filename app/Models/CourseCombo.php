<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseCombo extends BaseModel
{
    use HasFactory;
    public function pivot(){
    	return $this->hasMany(CourseCourseCombo::class, 'course_combo_id', 'id');
    }
    public function course()
    {
    	return $this->belongsToMany(Course::class);
    }
}