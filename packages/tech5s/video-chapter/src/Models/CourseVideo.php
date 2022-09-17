<?php

namespace Tech5s\VideoChapter\Models;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function notes()
    {
        return $this->hasMany(CourseVideoNote::class, 'course_video_id')->where('user_id', \Auth::id());
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_video_user', 'course_video_id', 'user_id');
    }
}
