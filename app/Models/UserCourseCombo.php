<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserCourseCombo extends BaseModel
{
    use HasFactory;
    public function courseCombo()
    {
        return $this->belongsTo(CourseCombo::class);
    }
}