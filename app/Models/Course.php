<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends BaseModel
{
    use HasFactory;
    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }
    public function pivot(){
    	return $this->hasMany(CourseCourseCategory::class, 'course_id', 'id');
    }
    public function category()
    {
    	return $this->belongsToMany(CourseCategory::class);
    }
}