<?php

namespace Tech5s\VideoChapter\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
