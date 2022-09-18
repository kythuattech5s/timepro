<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserCourse extends BaseModel
{
    use HasFactory;
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}