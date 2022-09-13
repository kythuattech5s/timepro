<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseCourseCombo extends BaseModel
{
    use HasFactory;
    protected $table = 'course_course_combo';
    public function course()
    {
    	return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}