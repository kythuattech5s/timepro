<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseCourseCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'course_course_category';
    public function courseCategory()
    {
    	return $this->belongsTo(CourseCategory::class, 'course_category_id', 'id');
    }
}